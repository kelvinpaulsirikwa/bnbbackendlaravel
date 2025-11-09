<?php

namespace App\Http\Controllers\BnBOwner;

use App\Http\Controllers\Controller;
use App\Models\BnbChat;
use App\Models\BnbChatMessage;
use App\Models\BnbBooking;
use App\Models\Motel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        $owner = Auth::user();

        $accessibleMotelIds = $this->getAccessibleMotelIds($owner);

        $availableMotels = Motel::whereIn('id', $accessibleMotelIds)
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        $status = $request->get('status');
        $requestedMotelId = $request->get('motel_id');

        $selectedMotelId = null;
        if ($requestedMotelId !== null && $requestedMotelId !== '') {
            $selectedMotelId = (int) $requestedMotelId;
            if (!in_array($selectedMotelId, $accessibleMotelIds, true)) {
                abort(403, 'Unauthorized motel selection.');
            }
        } elseif (session('selected_motel_id')) {
            $sessionMotel = (int) session('selected_motel_id');
            if (in_array($sessionMotel, $accessibleMotelIds, true)) {
                $selectedMotelId = $sessionMotel;
            }
        }

        if ($selectedMotelId === null && count($accessibleMotelIds) === 1) {
            $selectedMotelId = $accessibleMotelIds[0];
        }

        if ($selectedMotelId) {
            session(['selected_motel_id' => $selectedMotelId]);
        }

        $page = (int) $request->get('page', 1);
        $limit = (int) $request->get('limit', 15);

        $query = BnbChat::with(['customer', 'booking', 'motel'])
            ->whereIn('motel_id', $accessibleMotelIds)
            ->orderBy('updated_at', 'desc');

        if ($selectedMotelId) {
            $query->where('motel_id', $selectedMotelId);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $chats = $query->paginate($limit)->appends($request->query());

        $chatItems = collect($chats->items());
        $chatIds = $chatItems->pluck('id')->toArray();

        $latestMessages = collect();
        if (!empty($chatIds)) {
            $latestMessageIds = BnbChatMessage::whereIn('chat_id', $chatIds)
                ->select(DB::raw('MAX(id) as id'), 'chat_id')
                ->groupBy('chat_id')
                ->pluck('id')
                ->toArray();

            if (!empty($latestMessageIds)) {
                $latestMessages = BnbChatMessage::with('sender')
                    ->whereIn('id', $latestMessageIds)
                    ->get()
                    ->keyBy('chat_id');
            }
        }

        $chatViewModels = $chatItems->map(function (BnbChat $chat) use ($latestMessages) {
            $lastMessage = $latestMessages->get($chat->id);
            $booking = $chat->booking;
            $lastSenderName = null;
            if ($lastMessage && $lastMessage->sender_type === 'customer') {
                $lastSenderName = $chat->customer->username ?? 'Guest';
            } elseif ($lastMessage && $lastMessage->sender) {
                $lastSenderName = $lastMessage->sender->username ?? 'Staff';
            }

            $checkInDate = $booking && $booking->check_in_date
                ? Carbon::parse($booking->check_in_date)->format('Y-m-d')
                : null;
            $checkOutDate = $booking && $booking->check_out_date
                ? Carbon::parse($booking->check_out_date)->format('Y-m-d')
                : null;

            return [
                'id' => $chat->id,
                'motel' => $chat->motel ? [
                    'id' => $chat->motel->id,
                    'name' => $chat->motel->name,
                ] : null,
                'customer' => $chat->customer,
                'booking' => $booking ? [
                    'id' => $booking->id,
                    'check_in_date' => $checkInDate,
                    'check_out_date' => $checkOutDate,
                    'status' => $booking->status,
                ] : null,
                'status' => $chat->status,
                'updated_at' => $chat->updated_at,
                'last_message' => $lastMessage ? [
                    'message' => $lastMessage->message,
                    'sender_type' => $lastMessage->sender_type,
                    'sender_name' => $lastSenderName,
                    'created_at' => $lastMessage->created_at,
                ] : null,
            ];
        });

        $selectedMotel = $availableMotels->firstWhere('id', $selectedMotelId);

        return view('bnbowner.guest-chat.index', [
            'pageTitle' => 'Guest Chats',
            'chats' => $chats,
            'chatViewModels' => $chatViewModels,
            'availableMotels' => $availableMotels,
            'selectedMotelId' => $selectedMotelId,
            'status' => $status,
            'selectedMotel' => $selectedMotel,
        ]);
    }

    public function show($chatId)
    {
        $owner = Auth::user();
        $chat = BnbChat::with(['customer', 'booking', 'motel'])->findOrFail($chatId);

        if (!$this->canAccessChat($owner, $chat)) {
            abort(403, 'Unauthorized access to this chat.');
        }

        $messages = BnbChatMessage::with('sender')
            ->where('chat_id', $chat->id)
            ->orderBy('created_at')
            ->get();

        $booking = $chat->booking;
        $canSend = true;
        $sendRestriction = null;

        if ($booking && $booking->check_out_date) {
            $checkOutDate = Carbon::parse($booking->check_out_date);
            if ($checkOutDate->lt(Carbon::today())) {
                $canSend = false;
                $sendRestriction = 'This booking has already checked out (' . $checkOutDate->format('Y-m-d') . '). You can no longer send new messages.';
            }
        }

        return view('bnbowner.guest-chat.show', [
            'pageTitle' => 'Guest Chat',
            'chat' => $chat,
            'messages' => $messages,
            'canSend' => $canSend,
            'sendRestriction' => $sendRestriction,
        ]);
    }

    public function sendMessage(Request $request, $chatId)
    {
        $owner = Auth::user();
        $chat = BnbChat::with(['booking'])->findOrFail($chatId);

        if (!$this->canAccessChat($owner, $chat)) {
            abort(403, 'Unauthorized access to this chat.');
        }

        $request->validate([
            'message' => ['required', 'string', 'max:5000'],
        ]);

        $messageContent = trim($request->input('message'));

        if ($messageContent === '') {
            return redirect()
                ->route('bnbowner.chats.show', $chat->id)
                ->with('error', 'Message cannot be empty.');
        }

        if ($chat->booking_id) {
            $booking = $chat->booking ?? BnbBooking::find($chat->booking_id);
            if ($booking && $booking->check_out_date) {
                $checkOutDate = Carbon::parse($booking->check_out_date);
                if ($checkOutDate->lt(Carbon::today())) {
                    return redirect()
                        ->route('bnbowner.chats.show', $chat->id)
                        ->with('error', 'Cannot send messages for expired bookings.');
                }
            }
        }

        BnbChatMessage::create([
            'chat_id' => $chat->id,
            'sender_type' => 'bnbuser',
            'sender_id' => $owner->id,
            'message' => $messageContent,
            'read_status' => 'unread',
            'created_at' => now(),
        ]);

        $chat->touch();

        return redirect()
            ->route('bnbowner.chats.show', $chat->id)
            ->with('success', 'Message sent successfully.');
    }

    protected function getAccessibleMotelIds($owner): array
    {
        if (!$owner) {
            return [];
        }

        if ($owner->role === 'bnbowner') {
            return Motel::where('owner_id', $owner->id)
                ->pluck('id')
                ->map(fn ($id) => (int) $id)
                ->toArray();
        }

        if ($owner->motel_id) {
            return [(int) $owner->motel_id];
        }

        return [];
    }

    protected function canAccessChat($owner, BnbChat $chat): bool
    {
        $accessibleMotelIds = $this->getAccessibleMotelIds($owner);
        return in_array((int) $chat->motel_id, $accessibleMotelIds, true);
    }
}


