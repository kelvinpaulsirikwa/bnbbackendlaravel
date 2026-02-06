<?php

namespace App\Http\Controllers\UserApi;

use App\Http\Controllers\Controller;
use App\Models\BnbChat;
use App\Models\BnbChatMessage;
use App\Models\BnbChatAttachment;
use App\Models\BnbBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserChattingController extends Controller
{
    /**
     * @OA\Get(
     *     path="/customer/chats",
     *     tags={"Chat"},
     *     summary="Get customer chats",
     *     description="Chats for authenticated customer with motel and last_message (id, message, sender_type, sender_id, sender, created_at). Requires Bearer token.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(response=200, description="OK", @OA\JsonContent(
     *         @OA\Property(property="success", type="boolean"),
     *         @OA\Property(property="data", type="array", @OA\Items(
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="motel_id", type="integer"),
     *             @OA\Property(property="booking_id", type="integer", nullable=true),
     *             @OA\Property(property="status", type="string"),
     *             @OA\Property(property="created_at", type="string"),
     *             @OA\Property(property="updated_at", type="string"),
     *             @OA\Property(property="motel", type="object"),
     *             @OA\Property(property="last_message", type="object", nullable=true)
     *         )),
     *         @OA\Property(property="message", type="string")
     *     )),
     *     @OA\Response(response=500, description="Server error")
     * )
     */
    public function getCustomerChats(Request $request)
    {
        try {
            $customer = $request->user(); // Get authenticated customer from Sanctum
            $customerId = $customer->id;

            $chats = BnbChat::with('motel')
            ->where('customer_id', $customerId)
            ->orderBy('updated_at', 'desc')
            ->get();

            // Get chat IDs
            $chatIds = $chats->pluck('id')->toArray();

            // Get the latest message for each chat (only if there are chats)
            $latestMessages = collect();
            if (!empty($chatIds)) {
                // Using MAX(id) which works because id is auto-increment and latest message has highest id
                $latestMessageIds = BnbChatMessage::whereIn('chat_id', $chatIds)
                    ->select(DB::raw('MAX(id) as id'), 'chat_id')
                    ->groupBy('chat_id')
                    ->pluck('id')
                    ->toArray();

                // Load the actual latest messages
                if (!empty($latestMessageIds)) {
                    $latestMessages = BnbChatMessage::whereIn('id', $latestMessageIds)
                        ->with('sender')
                        ->get()
                        ->keyBy('chat_id');
                }
            }

            $chatsData = $chats->map(function($chat) use ($latestMessages) {
                $lastMessage = $latestMessages->get($chat->id);
                $senderInfo = null;

                if ($lastMessage && $lastMessage->sender) {
                    if ($lastMessage->sender_type === 'customer') {
                        $senderInfo = [
                            'id' => $lastMessage->sender->id,
                            'username' => $lastMessage->sender->username ?? 'Customer',
                            'userimage' => $lastMessage->sender->userimage ?? null,
                        ];
                    } elseif ($lastMessage->sender_type === 'bnbuser') {
                        $senderInfo = [
                            'id' => $lastMessage->sender->id,
                            'username' => $lastMessage->sender->username ?? 'Motel Staff',
                            'userimage' => $lastMessage->sender->profileimage ?? $lastMessage->sender->userimage ?? null,
                        ];
                    }
                }

                return [
                    'id' => $chat->id,
                    'motel_id' => $chat->motel_id,
                    'booking_id' => $chat->booking_id,
                    'status' => $chat->status,
                    'created_at' => $chat->created_at?->format('Y-m-d H:i:s'),
                    'updated_at' => $chat->updated_at?->format('Y-m-d H:i:s'),
                    'motel' => [
                        'id' => $chat->motel->id ?? null,
                        'name' => $chat->motel->name ?? 'Unknown Motel',
                        'front_image' => $chat->motel->front_image ?? null,
                        'street_address' => $chat->motel->street_address ?? null,
                    ],
                    'last_message' => $lastMessage ? [
                        'id' => $lastMessage->id,
                        'message' => $lastMessage->message,
                        'sender_type' => $lastMessage->sender_type,
                        'sender_id' => $lastMessage->sender_id,
                        'sender' => $senderInfo,
                        'created_at' => $lastMessage->created_at?->format('Y-m-d H:i:s'),
                    ] : null,
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $chatsData,
                'message' => 'Chats retrieved successfully'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve chats: ' . $e->getMessage(),
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/chat/{chatId}/messages",
     *     tags={"Chat"},
     *     summary="Get chat messages",
     *     description="Paginated or all (query: page, limit, all=true). Response: data (id, chat_id, sender_type, sender_id, message, read_status, created_at, sender, attachments). Requires Bearer token.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(name="chatId", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Parameter(name="page", in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter(name="limit", in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter(name="all", in="query", description="true to get all messages", @OA\Schema(type="boolean")),
     *     @OA\Response(response=200, description="OK"),
     *     @OA\Response(response=403, description="Unauthorized"),
     *     @OA\Response(response=404, description="Chat not found"),
     *     @OA\Response(response=500, description="Server error")
     * )
     */
    public function getChatMessages($chatId, Request $request)
    {
        try {
            $page = $request->get('page', 1);
            $limit = $request->get('limit', 50);
            // New parameter to get all messages - check if 'all' is set to 'true' or 1
            $getAll = filter_var($request->get('all', false), FILTER_VALIDATE_BOOLEAN);

            $customer = $request->user(); // Get authenticated customer from Sanctum
            $chat = BnbChat::find($chatId);

            if (!$chat) {
                return response()->json([
                    'success' => false,
                    'message' => 'Chat not found'
                ], 404);
            }

            // Verify chat belongs to authenticated customer
            if ($chat->customer_id !== $customer->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access to this chat'
                ], 403);
            }

            // If 'all' parameter is true, get all messages without pagination
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

            // Handle both paginated and non-paginated results
            $messagesCollection = $getAll ? $messages : collect($messages->items());
            
            // Map messages to data array (handles empty collection gracefully)
            $messagesData = $messagesCollection->map(function($message) {
                // Get sender info based on sender_type
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
                        'userimage' => $message->sender->userimage ?? null,
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
                    'attachments' => $message->attachments->map(function($attachment) {
                        return [
                            'id' => $attachment->id,
                            'file_path' => $attachment->file_path,
                            'file_type' => $attachment->file_type,
                            'uploaded_at' => $attachment->uploaded_at?->format('Y-m-d H:i:s'),
                        ];
                    }),
                ];
            });

            // Always return success, even if messages are empty
            $response = [
                'success' => true,
                'data' => $messagesData->values()->toArray(), // Convert to array
                'message' => $messagesCollection->isEmpty() 
                    ? 'No messages yet. Start the conversation!' 
                    : 'Messages retrieved successfully'
            ];

            // Add pagination info only if not getting all messages
            if (!$getAll) {
                $response['pagination'] = [
                    'current_page' => $messages->currentPage(),
                    'last_page' => $messages->lastPage(),
                    'per_page' => $messages->perPage(),
                    'total' => $messages->total(),
                ];
            } else {
                $response['pagination'] = [
                    'total' => $messages->count(),
                    'all' => true
                ];
            }

            return response()->json($response, 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve messages: ' . $e->getMessage(),
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/chat/send-message",
     *     tags={"Chat"},
     *     summary="Send message",
     *     description="Body: chat_id, message. Requires Bearer token.",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(required=true, @OA\JsonContent(required={"chat_id","message"}, @OA\Property(property="chat_id", type="integer"), @OA\Property(property="message", type="string"))),
     *     @OA\Response(response=201, description="Message sent"),
     *     @OA\Response(response=403, description="Unauthorized or booking expired"),
     *     @OA\Response(response=404, description="Chat not found"),
     *     @OA\Response(response=422, description="Validation failed"),
     *     @OA\Response(response=500, description="Server error")
     * )
     */
    public function sendMessage(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'chat_id' => 'required|integer|exists:bnb_chats,id',
                'message' => 'required|string|max:5000',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Verify chat exists and belongs to authenticated customer
            $customer = $request->user();
            $chat = BnbChat::find($request->chat_id);
            
            if (!$chat) {
                return response()->json([
                    'success' => false,
                    'message' => 'Chat not found'
                ], 404);
            }

            // Verify chat belongs to authenticated customer
            if ($chat->customer_id !== $customer->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access to this chat'
                ], 403);
            }

            // Check if booking is expired (if chat has a booking)
            if ($chat->booking_id) {
                $booking = BnbBooking::find($chat->booking_id);
                if ($booking) {
                    // Verify booking belongs to the authenticated customer
                    if ($booking->customer_id !== $customer->id) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Unauthorized access to this booking'
                        ], 403);
                    }

                    $today = Carbon::today();
                    $checkOutDate = Carbon::parse($booking->check_out_date);
                    
                    // Check if checkout date has passed (booking is expired)
                    if ($checkOutDate->lt($today)) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Cannot send messages for expired bookings. Your booking checkout date (' . $checkOutDate->format('Y-m-d') . ') has passed.',
                            'error' => 'Booking expired'
                        ], 403);
                    }
                }
            }

            // Trim and validate message content
            $messageContent = trim($request->message);
            
            if (empty($messageContent)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Message cannot be empty'
                ], 422);
            }

            // Create message in bnb_chat_messages table
            $message = BnbChatMessage::create([
                'chat_id' => $request->chat_id,
                'sender_type' => 'customer', // Always customer for authenticated user
                'sender_id' => $customer->id,
                'message' => $messageContent,
                'read_status' => 'unread', // 'unread' or 'read'
                'created_at' => now(),
            ]);

            // Update chat's updated_at timestamp to reflect new activity
            $chat->touch();

            // Load sender relationship
            $message->load('sender');

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
                    'userimage' => $message->sender->userimage ?? null,
                ];
            }

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
                    'sender' => $senderInfo,
                    'attachments' => [],
                ],
                'message' => 'Message sent successfully'
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send message: ' . $e->getMessage(),
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/chat/create-or-get",
     *     tags={"Chat"},
     *     summary="Create or get chat",
     *     description="Body: motel_id (required), booking_id?, started_by? (customer|bnbuser). Returns existing chat or creates new. Requires Bearer token.",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(required=true, @OA\JsonContent(
     *         required={"motel_id"},
     *         @OA\Property(property="motel_id", type="integer"),
     *         @OA\Property(property="booking_id", type="integer", nullable=true),
     *         @OA\Property(property="started_by", type="string", enum={"customer","bnbuser"}, nullable=true)
     *     )),
     *     @OA\Response(response=200, description="Existing chat", @OA\JsonContent(@OA\Property(property="success", type="boolean"), @OA\Property(property="data", type="object"), @OA\Property(property="message", type="string"))),
     *     @OA\Response(response=201, description="Chat created", @OA\JsonContent(@OA\Property(property="success", type="boolean"), @OA\Property(property="data", type="object", @OA\Property(property="id", type="integer"), @OA\Property(property="chat_id", type="integer"), @OA\Property(property="motel_id", type="integer"), @OA\Property(property="booking_id", type="integer", nullable=true), @OA\Property(property="customer_id", type="integer"), @OA\Property(property="status", type="string")), @OA\Property(property="message", type="string"))),
     *     @OA\Response(response=403, description="Unauthorized or booking expired"),
     *     @OA\Response(response=404, description="Booking not found"),
     *     @OA\Response(response=422, description="Validation failed"),
     *     @OA\Response(response=500, description="Server error")
     * )
     */
    public function createOrGetChat(Request $request)
    {
        try {
            $customer = $request->user(); // Get authenticated customer from Sanctum
            $customerId = $customer->id;

            $validator = Validator::make($request->all(), [
                'booking_id' => 'nullable|integer|exists:bnb_bookings,id',
                'motel_id' => 'required|integer|exists:bnb_motels,id',
                'started_by' => 'nullable|string|in:customer,bnbuser',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $startedBy = $request->input('started_by', 'customer');

            // Validate booking if provided
            if ($request->booking_id) {
                $booking = BnbBooking::with('room')->find($request->booking_id);
                
                if (!$booking) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Booking not found'
                    ], 404);
                }

                // Verify booking belongs to the authenticated customer
                if ($booking->customer_id !== $customerId) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Unauthorized access to this booking'
                    ], 403);
                }

                // Check if booking checkout date has passed
                $today = Carbon::today();
                $checkOutDate = Carbon::parse($booking->check_out_date);
                
                if ($checkOutDate->lt($today)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Cannot create chat for expired bookings. Your booking checkout date (' . $checkOutDate->format('Y-m-d') . ') has passed.',
                        'error' => 'Booking expired'
                    ], 403);
                }

                // Verify booking motel matches the provided motel_id (if room exists)
                if ($booking->room && $booking->room->motelid != $request->motel_id) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Booking does not belong to the specified motel'
                    ], 422);
                }
            }

            // Check if chat already exists
            $existingChat = BnbChat::where('customer_id', $customerId)
                ->where('motel_id', $request->motel_id)
                ->when($request->booking_id, function($query) use ($request) {
                    return $query->where('booking_id', $request->booking_id);
                })
                ->first();

            if ($existingChat) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'id' => $existingChat->id,
                        'chat_id' => $existingChat->id,
                        'motel_id' => $existingChat->motel_id,
                        'booking_id' => $existingChat->booking_id,
                    ],
                    'message' => 'Existing chat retrieved'
                ], 200);
            }

            // Create new chat in bnb_chats table
            $chat = BnbChat::create([
                'booking_id' => $request->booking_id,
                'motel_id' => $request->motel_id,
                'customer_id' => $customerId,
                'started_by' => $startedBy,
                'status' => 'active',
            ]);

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $chat->id,
                    'chat_id' => $chat->id,
                    'motel_id' => $chat->motel_id,
                    'booking_id' => $chat->booking_id,
                    'customer_id' => $chat->customer_id,
                    'status' => $chat->status,
                ],
                'message' => 'Chat created successfully. You can now send messages.'
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create chat: ' . $e->getMessage(),
                'error' => $e->getMessage()
            ], 500);
        }
    }
}