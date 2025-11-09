<?php

namespace App\Http\Controllers\AdminApi;

use App\Http\Controllers\Controller;
use App\Models\BnbChat;
use App\Models\BnbChatMessage;
use App\Models\BnbBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class AdminChattingController extends Controller
{
    /**
     * Get paginated chats for motel staff
     */
    public function getChats(Request $request)
    {
        try {
            $admin = $request->user();

            if (!$admin) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthenticated',
                ], 401);
            }

            if (!$admin->motel_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'No motel associated with this account',
                ], 403);
            }

            $page = (int) $request->get('page', 1);
            $limit = (int) $request->get('limit', 20);
            $status = $request->get('status');

            $query = BnbChat::with(['customer', 'booking'])
                ->where('motel_id', $admin->motel_id)
                ->orderBy('updated_at', 'desc');

            if ($status) {
                $query->where('status', $status);
            }

            $chats = $query->paginate($limit, ['*'], 'page', $page);

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

            $data = $chatItems->map(function ($chat) use ($latestMessages) {
                $lastMessage = $latestMessages->get($chat->id);
                $customer = $chat->customer;
                $booking = $chat->booking;

                return [
                    'id' => $chat->id,
                    'motel_id' => $chat->motel_id,
                    'booking_id' => $chat->booking_id,
                    'status' => $chat->status,
                    'started_by' => $chat->started_by,
                    'created_at' => $chat->created_at?->format('Y-m-d H:i:s'),
                    'updated_at' => $chat->updated_at?->format('Y-m-d H:i:s'),
                    'customer' => $customer ? [
                        'id' => $customer->id,
                        'username' => $customer->username,
                        'useremail' => $customer->useremail,
                        'userimage' => $customer->userimage,
                        'phonenumber' => $customer->phonenumber,
                    ] : null,
                    'booking' => $booking ? [
                        'id' => $booking->id,
                        'check_in_date' => optional($booking->check_in_date)->format('Y-m-d'),
                        'check_out_date' => optional($booking->check_out_date)->format('Y-m-d'),
                        'status' => $booking->status,
                    ] : null,
                    'last_message' => $lastMessage ? [
                        'id' => $lastMessage->id,
                        'message' => $lastMessage->message,
                        'sender_type' => $lastMessage->sender_type,
                        'created_at' => $lastMessage->created_at?->format('Y-m-d H:i:s'),
                    ] : null,
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $data->values(),
                'pagination' => [
                    'current_page' => $chats->currentPage(),
                    'last_page' => $chats->lastPage(),
                    'per_page' => $chats->perPage(),
                    'total' => $chats->total(),
                ],
                'message' => 'Chats retrieved successfully',
            ], 200);

        } catch (\Exception $e) {
            Log::error('Admin get chats failed', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve chats: ' . $e->getMessage(),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get chat messages for admins
     */
    public function getChatMessages($chatId, Request $request)
    {
        try {
            $admin = $request->user();

            if (!$admin) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthenticated',
                ], 401);
            }

            $chat = BnbChat::find($chatId);

            if (!$chat || (int) $chat->motel_id !== (int) $admin->motel_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access to this chat',
                ], 403);
            }

            $page = (int) $request->get('page', 1);
            $limit = (int) $request->get('limit', 50);
            $getAll = filter_var($request->get('all', false), FILTER_VALIDATE_BOOLEAN);

            if ($getAll) {
                $messages = BnbChatMessage::with(['attachments', 'sender'])
                    ->where('chat_id', $chatId)
                    ->orderBy('created_at', 'desc')
                    ->get();
            } else {
                $messages = BnbChatMessage::with(['attachments', 'sender'])
                    ->where('chat_id', $chatId)
                    ->orderBy('created_at', 'desc')
                    ->paginate($limit, ['*'], 'page', $page);
            }

            $collection = $getAll ? $messages : collect($messages->items());

            $data = $collection->map(function ($message) {
                $senderInfo = null;

                if ($message->sender_type === 'customer' && $message->sender) {
                    $senderInfo = [
                        'id' => $message->sender->id,
                        'username' => $message->sender->username ?? 'Customer',
                        'userimage' => $message->sender->userimage ?? null,
                    ];
                } elseif ($message->sender_type === 'bnbuser' && $message->sender) {
                    $senderInfo = [
                        'id' => $message->sender->id,
                        'username' => $message->sender->username ?? 'Motel Staff',
                        'userimage' => $message->sender->profileimage ?? null,
                    ];
                }

                return [
                    'id' => $message->id,
                    'chat_id' => $message->chat_id,
                    'sender_type' => $message->sender_type,
                    'sender_id' => $message->sender_id,
                    'message' => $message->message,
                    'read_status' => $message->read_status,
                    'created_at' => $message->created_at?->format('Y-m-d H:i:s'),
                    'sender' => $senderInfo,
                    'attachments' => $message->attachments->map(function ($attachment) {
                        return [
                            'id' => $attachment->id,
                            'file_path' => $attachment->file_path,
                            'file_type' => $attachment->file_type,
                            'uploaded_at' => $attachment->uploaded_at?->format('Y-m-d H:i:s'),
                        ];
                    }),
                ];
            });

            $response = [
                'success' => true,
                'data' => $data->values()->toArray(),
                'message' => $collection->isEmpty()
                    ? 'No messages yet. Start the conversation!'
                    : 'Messages retrieved successfully',
            ];

            if ($getAll) {
                $response['pagination'] = [
                    'total' => $messages->count(),
                    'all' => true,
                ];
            } else {
                $response['pagination'] = [
                    'current_page' => $messages->currentPage(),
                    'last_page' => $messages->lastPage(),
                    'per_page' => $messages->perPage(),
                    'total' => $messages->total(),
                ];
            }

            return response()->json($response, 200);

        } catch (\Exception $e) {
            Log::error('Admin get chat messages failed', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve messages: ' . $e->getMessage(),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Send a message as motel staff
     */
    public function sendMessage(Request $request)
    {
        try {
            $admin = $request->user();

            if (!$admin) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthenticated',
                ], 401);
            }

            $validator = Validator::make($request->all(), [
                'chat_id' => 'required|integer|exists:bnb_chats,id',
                'message' => 'required|string|max:5000',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $chat = BnbChat::find($request->chat_id);

            if (!$chat || (int) $chat->motel_id !== (int) $admin->motel_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access to this chat',
                ], 403);
            }

            if ($chat->booking_id) {
                $booking = BnbBooking::find($chat->booking_id);
                if ($booking) {
                    $today = Carbon::today();
                    $checkOutDate = Carbon::parse($booking->check_out_date);

                    if ($checkOutDate->lt($today)) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Cannot send messages for expired bookings. The checkout date (' . $checkOutDate->format('Y-m-d') . ') has passed.',
                            'error' => 'Booking expired',
                        ], 403);
                    }
                }
            }

            $messageContent = trim($request->message);

            if ($messageContent === '') {
                return response()->json([
                    'success' => false,
                    'message' => 'Message cannot be empty',
                ], 422);
            }

            $message = BnbChatMessage::create([
                'chat_id' => $request->chat_id,
                'sender_type' => 'bnbuser',
                'sender_id' => $admin->id,
                'message' => $messageContent,
                'read_status' => 'unread',
                'created_at' => now(),
            ]);

            $chat->touch();
            $message->load('sender');

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $message->id,
                    'chat_id' => $message->chat_id,
                    'sender_type' => $message->sender_type,
                    'sender_id' => $message->sender_id,
                    'message' => $message->message,
                    'read_status' => $message->read_status,
                    'created_at' => $message->created_at?->format('Y-m-d H:i:s'),
                    'sender' => $message->sender ? [
                        'id' => $message->sender->id,
                        'username' => $message->sender->username ?? 'Motel Staff',
                        'userimage' => $message->sender->profileimage ?? null,
                    ] : null,
                    'attachments' => [],
                ],
                'message' => 'Message sent successfully',
            ], 201);

        } catch (\Exception $e) {
            Log::error('Admin send message failed', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to send message: ' . $e->getMessage(),
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}


