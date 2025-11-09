<?php

namespace App\Http\Controllers\Admin;

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
        $admin = Auth::user();

        if (!$admin) {
            abort(401, 'Unauthenticated');
        }

        $pageTitle = 'Guest Chats';
        $status = $request->get('status');
        $motelId = $request->get('motel_id');
        $search = $request->get('search');
        $limit = (int) $request->get('limit', 20);

        $availableMotels = Motel::with('owner')
            ->select('id', 'name', 'owner_id')
            ->orderBy('name')
            ->get();

        $query = BnbChat::with(['customer', 'booking', 'motel.owner'])
            ->orderBy('updated_at', 'desc');

        if ($motelId) {
            $query->where('motel_id', $motelId);
        }

        if ($status) {
            $query->where('status', $status);
        }

        if ($search) {
            $query->whereHas('customer', function ($q) use ($search) {
                $q->where('username', 'like', '%' . $search . '%')
                    ->orWhere('useremail', 'like', '%' . $search . '%');
            });
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
            $customer = $chat->customer;
            $motel = $chat->motel;

            $checkInDate = $booking && $booking->check_in_date
                ? Carbon::parse($booking->check_in_date)->format('Y-m-d')
                : null;
            $checkOutDate = $booking && $booking->check_out_date
                ? Carbon::parse($booking->check_out_date)->format('Y-m-d')
                : null;

            $lastSenderName = null;
            if ($lastMessage) {
                if ($lastMessage->sender_type === 'customer') {
                    $lastSenderName = $customer->username ?? 'Guest';
                } elseif ($lastMessage->sender) {
                    $lastSenderName = $lastMessage->sender->username ?? 'Staff';
                }
            }

            return [
                'id' => $chat->id,
                'status' => $chat->status,
                'updated_at' => $chat->updated_at,
                'customer' => $customer,
                'motel' => $motel,
                'booking' => $booking ? [
                    'id' => $booking->id,
                    'check_in_date' => $checkInDate,
                    'check_out_date' => $checkOutDate,
                    'status' => $booking->status,
                ] : null,
                'last_message' => $lastMessage ? [
                    'message' => $lastMessage->message,
                    'sender_type' => $lastMessage->sender_type,
                    'sender_name' => $lastSenderName,
                    'created_at' => $lastMessage->created_at,
                ] : null,
            ];
        });

        return view('adminpages.chat.index', [
            'pageTitle' => $pageTitle,
            'chats' => $chats,
            'chatViewModels' => $chatViewModels,
            'availableMotels' => $availableMotels,
            'status' => $status,
            'selectedMotelId' => $motelId,
            'search' => $search,
        ]);
    }

    public function show($chatId)
    {
        $admin = Auth::user();

        if (!$admin) {
            abort(401, 'Unauthenticated');
        }

        $chat = BnbChat::with(['customer', 'booking', 'motel.owner'])->findOrFail($chatId);

        $messages = BnbChatMessage::with('sender')
            ->where('chat_id', $chat->id)
            ->orderBy('created_at')
            ->get();

        return view('adminpages.chat.show', [
            'pageTitle' => 'Guest Chat',
            'chat' => $chat,
            'messages' => $messages,
        ]);
    }

    public function sendMessage(Request $request, $chatId)
    {
        $admin = Auth::user();

        if (!$admin) {
            abort(401, 'Unauthenticated');
        }

        $chat = BnbChat::with('booking')->findOrFail($chatId);

        $request->validate([
            'message' => ['required', 'string', 'max:5000'],
        ]);

        $messageContent = trim($request->input('message'));

        if ($messageContent === '') {
            return redirect()
                ->route('adminpages.chats.show', $chat->id)
                ->with('error', 'Message cannot be empty.');
        }

        if ($chat->booking_id) {
            $booking = $chat->booking ?? BnbBooking::find($chat->booking_id);
            if ($booking && $booking->check_out_date) {
                $checkOutDate = Carbon::parse($booking->check_out_date);
                if ($checkOutDate->lt(Carbon::today())) {
                    return redirect()
                        ->route('adminpages.chats.show', $chat->id)
                        ->with('error', 'Cannot send messages for expired bookings.');
                }
            }
        }

        BnbChatMessage::create([
            'chat_id' => $chat->id,
            'sender_type' => 'bnbuser',
            'sender_id' => $admin->id,
            'message' => $messageContent,
            'read_status' => 'unread',
            'created_at' => now(),
        ]);

        $chat->touch();

        return redirect()
            ->route('adminpages.chats.show', $chat->id)
            ->with('success', 'Message sent successfully.');
    }
}


