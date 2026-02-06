<?php

namespace App\Http\Controllers\AdminApi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\BnbRoom;
use App\Models\BnbRoomImage;
use App\Models\BnbRoomItem;
use App\Models\RoomType;
use App\Models\Motel;

class AdminRoomApiController extends Controller
{
    /**
     * @OA\Get(path="/admin/motels/{motelId}/rooms", tags={"Admin"}, summary="Get motel rooms",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(in="path", name="motelId", required=true, @OA\Schema(type="integer")),
     *     @OA\Parameter(in="query", name="page", @OA\Schema(type="integer")), @OA\Parameter(in="query", name="limit", @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="OK", @OA\JsonContent(@OA\Property(property="success", type="boolean"), @OA\Property(property="message", type="string"), @OA\Property(property="data", type="array", @OA\Items(type="object", @OA\Property(property="id", type="integer"), @OA\Property(property="roomnumber", type="string"), @OA\Property(property="price_per_night", type="number"), @OA\Property(property="office_price_per_night", type="number", nullable=true), @OA\Property(property="frontimage", type="string", nullable=true), @OA\Property(property="status", type="string"), @OA\Property(property="room_type", type="object"), @OA\Property(property="motel", type="object"))), @OA\Property(property="pagination", type="object"))),
     *     @OA\Response(response=401, description="Unauthorized"), @OA\Response(response=422, description="Validation failed"), @OA\Response(response=500, description="Server error"))
     */
    public function getMotelRooms(Request $request, $motelId)
    {
        try {
            $validator = Validator::make($request->all(), [
                'page' => 'integer|min:1',
                'limit' => 'integer|min:1|max:100',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);

            $rooms = BnbRoom::with(['roomType', 'motel'])
                ->where('motelid', $motelId)
                ->orderBy('created_at', 'desc')
                ->paginate($limit, ['*'], 'page', $page);

            $transformedRooms = collect($rooms->items())->map(function ($room) {
                return [
                    'id' => $room->id,
                    'roomnumber' => $room->room_number,
                    'price_per_night' => $room->price_per_night,
                    'office_price_per_night' => $room->office_price_per_night,
                    'frontimage' => $room->frontimage,
                    'status' => $room->status,
                    'created_at' => $room->created_at ? $room->created_at->format('Y-m-d H:i:s') : null,
                    'room_type' => $room->roomType ? [
                        'id' => $room->roomType->id,
                        'name' => $room->roomType->name,
                    ] : null,
                    'motel' => $room->motel ? [
                        'id' => $room->motel->id,
                        'name' => $room->motel->name,
                    ] : null,
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Rooms retrieved successfully',
                'data' => $transformedRooms,
                'pagination' => [
                    'current_page' => $rooms->currentPage(),
                    'last_page' => $rooms->lastPage(),
                    'per_page' => $rooms->perPage(),
                    'total' => $rooms->total(),
                ]
            ], 200);

        } catch (\Exception $e) {
            Log::error("Error fetching motel rooms: " . $e->getMessage(), ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving rooms',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get room details
     */
    public function getRoomDetails($roomId)
    {
        try {
            $room = BnbRoom::with(['roomType', 'motel', 'images', 'items'])
                ->find($roomId);

            if (!$room) {
                return response()->json([
                    'success' => false,
                    'message' => 'Room not found'
                ], 404);
            }

            $transformedRoom = [
                'id' => $room->id,
                'roomnumber' => $room->room_number,
                'price_per_night' => $room->price_per_night,
                'office_price_per_night' => $room->office_price_per_night,
                'frontimage' => $room->frontimage,
                'status' => $room->status,
                'created_at' => $room->created_at ? $room->created_at->format('Y-m-d H:i:s') : null,
                'room_type' => $room->roomType ? [
                    'id' => $room->roomType->id,
                    'name' => $room->roomType->name,
                ] : null,
                'motel' => $room->motel ? [
                    'id' => $room->motel->id,
                    'name' => $room->motel->name,
                ] : null,
                'images' => $room->images->map(function ($image) {
                    return [
                        'id' => $image->id,
                        'bnb_room_id' => $image->bnbroomid,
                        'imagepath' => $image->imagepath,
                        'description' => $image->description,
                        'created_at' => $image->created_at ? $image->created_at->format('Y-m-d H:i:s') : null,
                        'full_image_url' => $image->imagepath ? url('storage/' . $image->imagepath) : null,
                    ];
                }),
                'items' => $room->items ? collect($room->items)->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'bnb_room_id' => $item->bnbroomid,
                        'item_name' => $item->name,
                        'item_description' => $item->description,
                        'created_at' => $item->created_at ? $item->created_at->format('Y-m-d H:i:s') : null,
                    ];
                }) : [],
            ];

            return response()->json([
                'success' => true,
                'message' => 'Room details retrieved successfully',
                'data' => $transformedRoom
            ], 200);

        } catch (\Exception $e) {
            Log::error("Error fetching room details: " . $e->getMessage(), ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving room details',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Put(path="/admin/rooms/{roomId}", tags={"Admin"}, summary="Update room",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(in="path", name="roomId", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(@OA\JsonContent(@OA\Property(property="room_number", type="string"), @OA\Property(property="price_per_night", type="number"), @OA\Property(property="office_price_per_night", type="number"), @OA\Property(property="status", type="string"), @OA\Property(property="room_type_id", type="integer"), @OA\Property(property="front_image", type="string", format="binary"))),
     *     @OA\Response(response=200, description="Updated", @OA\JsonContent(@OA\Property(property="success", type="boolean"), @OA\Property(property="message", type="string"), @OA\Property(property="data", type="object"))),
     *     @OA\Response(response=401, description="Unauthorized"), @OA\Response(response=404, description="Room not found"), @OA\Response(response=422, description="Validation failed"), @OA\Response(response=500, description="Server error"))
     */
    public function updateRoom(Request $request, $roomId)
    {
        try {
            $validator = Validator::make($request->all(), [
                'price_per_night' => 'nullable|numeric|min:0',
                'office_price_per_night' => 'nullable|numeric|min:0',
                'frontimage' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'status' => 'nullable|in:free,maintenance',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $room = BnbRoom::find($roomId);
            if (!$room) {
                return response()->json([
                    'success' => false,
                    'message' => 'Room not found'
                ], 404);
            }

            $updateData = [];

            // Handle front image upload
            if ($request->hasFile('frontimage')) {
                // Delete old image
                if ($room->frontimage && Storage::disk('public')->exists($room->frontimage)) {
                    Storage::disk('public')->delete($room->frontimage);
                }

                $file = $request->file('frontimage');
                $extension = $file->getClientOriginalExtension();
                
                // Create custom filename: bnbroomimage/motelnamehowuploadedtimespend.png
                $motel = $room->motel;
                if ($motel) {
                    $motelName = Str::slug($motel->name, '');
                    $uploadTime = now()->format('YmdHis');
                    $randomString = Str::random(8);
                    $filename = "{$motelName}room{$room->room_number}how{$uploadTime}{$randomString}.{$extension}";
                    
                    // Store in bnbroomimage folder
                    $path = $file->storeAs('bnbroomimage', $filename, 'public');
                    $updateData['frontimage'] = $path;
                }
            }

            // Update other fields
            if ($request->has('price_per_night')) {
                $updateData['price_per_night'] = $request->price_per_night;
            }
            if ($request->has('office_price_per_night')) {
                $updateData['office_price_per_night'] = $request->office_price_per_night;
            }
            if ($request->has('status')) {
                $updateData['status'] = $request->status;
            }

            $room->update($updateData);

            return response()->json([
                'success' => true,
                'message' => 'Room updated successfully',
                'data' => [
                    'id' => $room->id,
                    'roomnumber' => $room->room_number,
                    'price_per_night' => $room->price_per_night,
                    'office_price_per_night' => $room->office_price_per_night,
                    'frontimage' => $room->frontimage,
                    'status' => $room->status,
                    'full_image_url' => $room->frontimage ? url('storage/' . $room->frontimage) : null,
                ]
            ], 200);

        } catch (\Exception $e) {
            Log::error("Error updating room: " . $e->getMessage(), ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating room',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(path="/admin/rooms/{roomId}/images", tags={"Admin"}, summary="Get room images",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(in="path", name="roomId", required=true, @OA\Schema(type="integer")),
     *     @OA\Parameter(in="query", name="page", @OA\Schema(type="integer")), @OA\Parameter(in="query", name="limit", @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="OK", @OA\JsonContent(@OA\Property(property="success", type="boolean"), @OA\Property(property="message", type="string"), @OA\Property(property="data", type="array", @OA\Items(type="object", @OA\Property(property="id", type="integer"), @OA\Property(property="bnb_rooms_id", type="integer"), @OA\Property(property="filepath", type="string"), @OA\Property(property="full_image_url", type="string", nullable=true))), @OA\Property(property="pagination", type="object"))),
     *     @OA\Response(response=401, description="Unauthorized"), @OA\Response(response=404, description="Room not found"), @OA\Response(response=500, description="Server error"))
     */
    public function getRoomImages(Request $request, $roomId)
    {
        try {
            $validator = Validator::make($request->all(), [
                'page' => 'integer|min:1',
                'limit' => 'integer|min:1|max:100',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);

            $images = BnbRoomImage::where('bnbroomid', $roomId)
                ->orderBy('created_at', 'desc')
                ->paginate($limit, ['*'], 'page', $page);

            $transformedImages = $images->map(function ($image) {
                return [
                    'id' => $image->id,
                    'bnb_room_id' => $image->bnbroomid,
                    'imagepath' => $image->imagepath,
                    'description' => $image->description,
                    'created_at' => $image->created_at ? $image->created_at->format('Y-m-d H:i:s') : null,
                    'full_image_url' => $image->imagepath ? url('storage/' . $image->imagepath) : null,
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Room images retrieved successfully',
                'data' => $transformedImages,
                'pagination' => [
                    'current_page' => $images->currentPage(),
                    'last_page' => $images->lastPage(),
                    'per_page' => $images->perPage(),
                    'total' => $images->total(),
                ]
            ], 200);

        } catch (\Exception $e) {
            Log::error("Error fetching room images: " . $e->getMessage(), ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving room images',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Post(path="/admin/room-images", tags={"Admin"}, summary="Create room image",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(required=true, @OA\JsonContent(required={"bnb_rooms_id"}, @OA\Property(property="bnb_rooms_id", type="integer"), @OA\Property(property="image", type="string", format="binary"), @OA\Property(property="description", type="string"))),
     *     @OA\Response(response=201, description="Created", @OA\JsonContent(@OA\Property(property="success", type="boolean"), @OA\Property(property="message", type="string"), @OA\Property(property="data", type="object"))),
     *     @OA\Response(response=401, description="Unauthorized"), @OA\Response(response=404, description="Room not found"), @OA\Response(response=422, description="Validation failed"), @OA\Response(response=500, description="Server error"))
     */
    public function createRoomImage(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'bnb_room_id' => 'required|integer|exists:bnbrooms,id',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'description' => 'nullable|string|max:500',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $room = BnbRoom::find($request->bnb_room_id);
            if (!$room) {
                return response()->json([
                    'success' => false,
                    'message' => 'Room not found'
                ], 404);
            }

            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            
            // Create custom filename: bnbroomimage/motelnamehowuploadedtimespend.png
            $motel = $room->motel;
            if ($motel) {
                $motelName = Str::slug($motel->name, '');
                $uploadTime = now()->format('YmdHis');
                $randomString = Str::random(8);
                $filename = "{$motelName}room{$room->room_number}how{$uploadTime}{$randomString}.{$extension}";
                
                // Store in bnbroomimage folder
                $path = $file->storeAs('bnbroomimage', $filename, 'public');

                $roomImage = BnbRoomImage::create([
                    'bnbroomid' => $request->bnb_room_id,
                    'imagepath' => $path,
                    'description' => $request->description ?? '',
                    'created_by' => auth()->id() ?? 1, // Use authenticated user ID or default to 1
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Room image uploaded successfully',
                    'data' => [
                        'id' => $roomImage->id,
                        'bnb_room_id' => $roomImage->bnb_room_id,
                        'imagepath' => $roomImage->imagepath,
                        'description' => $roomImage->description,
                        'created_at' => $roomImage->created_at ? $roomImage->created_at->format('Y-m-d H:i:s') : null,
                        'full_image_url' => url('storage/' . $roomImage->imagepath),
                    ]
                ], 201);
            }

            return response()->json([
                'success' => false,
                'message' => 'No image file provided'
            ], 400);

        } catch (\Exception $e) {
            Log::error("Error creating room image: " . $e->getMessage(), ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while uploading image',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Put(path="/admin/room-images/{id}", tags={"Admin"}, summary="Update room image",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(in="path", name="id", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(@OA\JsonContent(@OA\Property(property="image", type="string", format="binary"), @OA\Property(property="description", type="string"))),
     *     @OA\Response(response=200, description="Updated", @OA\JsonContent(@OA\Property(property="success", type="boolean"), @OA\Property(property="message", type="string"), @OA\Property(property="data", type="object"))),
     *     @OA\Response(response=401, description="Unauthorized"), @OA\Response(response=404, description="Not found"), @OA\Response(response=422, description="Validation failed"), @OA\Response(response=500, description="Server error"))
     */
    public function updateRoomImage(Request $request, $imageId)
    {
        try {
            $validator = Validator::make($request->all(), [
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'description' => 'nullable|string|max:500',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $roomImage = BnbRoomImage::find($imageId);
            if (!$roomImage) {
                return response()->json([
                    'success' => false,
                    'message' => 'Room image not found'
                ], 404);
            }

            $updateData = [];

            // Handle new image upload
            if ($request->hasFile('image')) {
                // Delete old image
                if ($roomImage->imagepath && Storage::disk('public')->exists($roomImage->imagepath)) {
                    Storage::disk('public')->delete($roomImage->imagepath);
                }

                $room = $roomImage->room;
                if ($room && $room->motel) {
                    $file = $request->file('image');
                    $extension = $file->getClientOriginalExtension();
                    
                    // Create custom filename
                    $motelName = Str::slug($room->motel->name, '');
                    $uploadTime = now()->format('YmdHis');
                    $randomString = Str::random(8);
                    $filename = "{$motelName}room{$room->room_number}how{$uploadTime}{$randomString}.{$extension}";
                    
                    // Store in bnbroomimage folder
                    $path = $file->storeAs('bnbroomimage', $filename, 'public');
                    $updateData['imagepath'] = $path;
                }
            }

            // Update description
            if ($request->has('description')) {
                $updateData['description'] = $request->description;
            }

            $roomImage->update($updateData);

            return response()->json([
                'success' => true,
                'message' => 'Room image updated successfully',
                'data' => [
                    'id' => $roomImage->id,
                    'bnb_room_id' => $roomImage->bnb_room_id,
                    'imagepath' => $roomImage->imagepath,
                    'description' => $roomImage->description,
                    'created_at' => $roomImage->created_at ? $roomImage->created_at->format('Y-m-d H:i:s') : null,
                    'full_image_url' => $roomImage->imagepath ? url('storage/' . $roomImage->imagepath) : null,
                ]
            ], 200);

        } catch (\Exception $e) {
            Log::error("Error updating room image: " . $e->getMessage(), ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating image',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Delete(path="/admin/room-images/{id}", tags={"Admin"}, summary="Delete room image",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(in="path", name="id", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Deleted", @OA\JsonContent(@OA\Property(property="success", type="boolean"), @OA\Property(property="message", type="string"))),
     *     @OA\Response(response=401, description="Unauthorized"), @OA\Response(response=404, description="Not found"), @OA\Response(response=500, description="Server error"))
     */
    public function deleteRoomImage($imageId)
    {
        try {
            $roomImage = BnbRoomImage::find($imageId);
            if (!$roomImage) {
                return response()->json([
                    'success' => false,
                    'message' => 'Room image not found'
                ], 404);
            }

            // Delete file from storage
            if ($roomImage->imagepath && Storage::disk('public')->exists($roomImage->imagepath)) {
                Storage::disk('public')->delete($roomImage->imagepath);
            }

            $roomImage->delete();

            return response()->json([
                'success' => true,
                'message' => 'Room image deleted successfully'
            ], 200);

        } catch (\Exception $e) {
            Log::error("Error deleting room image: " . $e->getMessage(), ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting image',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(path="/admin/rooms/{roomId}/items", tags={"Admin"}, summary="Get room items",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(in="path", name="roomId", required=true, @OA\Schema(type="integer")),
     *     @OA\Parameter(in="query", name="page", @OA\Schema(type="integer")), @OA\Parameter(in="query", name="limit", @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="OK", @OA\JsonContent(@OA\Property(property="success", type="boolean"), @OA\Property(property="message", type="string"), @OA\Property(property="data", type="array", @OA\Items(type="object", @OA\Property(property="id", type="integer"), @OA\Property(property="bnb_rooms_id", type="integer"), @OA\Property(property="item_name", type="string"), @OA\Property(property="quantity", type="integer"), @OA\Property(property="description", type="string", nullable=true))), @OA\Property(property="pagination", type="object"))),
     *     @OA\Response(response=401, description="Unauthorized"), @OA\Response(response=404, description="Room not found"), @OA\Response(response=500, description="Server error"))
     */
    public function getRoomItems(Request $request, $roomId)
    {
        try {
            $validator = Validator::make($request->all(), [
                'page' => 'integer|min:1',
                'limit' => 'integer|min:1|max:100',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);

            $items = BnbRoomItem::where('bnbroomid', $roomId)
                ->orderBy('created_at', 'desc')
                ->paginate($limit, ['*'], 'page', $page);

            $transformedItems = $items->map(function ($item) {
                return [
                    'id' => $item->id,
                    'bnb_room_id' => $item->bnbroomid,
                    'item_name' => $item->name,
                    'item_description' => $item->description,
                    'created_at' => $item->created_at ? $item->created_at->format('Y-m-d H:i:s') : null,
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Room items retrieved successfully',
                'data' => $transformedItems,
                'pagination' => [
                    'current_page' => $items->currentPage(),
                    'last_page' => $items->lastPage(),
                    'per_page' => $items->perPage(),
                    'total' => $items->total(),
                ]
            ], 200);

        } catch (\Exception $e) {
            Log::error("Error fetching room items: " . $e->getMessage(), ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving room items',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Post(path="/admin/room-items", tags={"Admin"}, summary="Create room item",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(required=true, @OA\JsonContent(required={"bnb_rooms_id","item_name","quantity"}, @OA\Property(property="bnb_rooms_id", type="integer"), @OA\Property(property="item_name", type="string"), @OA\Property(property="quantity", type="integer"), @OA\Property(property="description", type="string"))),
     *     @OA\Response(response=201, description="Created", @OA\JsonContent(@OA\Property(property="success", type="boolean"), @OA\Property(property="message", type="string"), @OA\Property(property="data", type="object"))),
     *     @OA\Response(response=401, description="Unauthorized"), @OA\Response(response=404, description="Room not found"), @OA\Response(response=422, description="Validation failed"), @OA\Response(response=500, description="Server error"))
     */
    public function createRoomItem(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'bnb_room_id' => 'required|integer|exists:bnbrooms,id',
                'item_name' => 'required|string|max:255',
                'item_description' => 'nullable|string|max:500',
                'quantity' => 'required|integer|min:1',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $roomItem = BnbRoomItem::create([
                'bnbroomid' => $request->bnb_room_id,
                'name' => $request->item_name,
                'description' => $request->item_description ?? '',
                'created_by' => auth()->id() ?? 1, // Use authenticated user ID or default to 1
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Room item created successfully',
                'data' => [
                    'id' => $roomItem->id,
                    'bnb_room_id' => $roomItem->bnbroomid,
                    'item_name' => $roomItem->name,
                    'item_description' => $roomItem->description,
                    'created_at' => $roomItem->created_at ? $roomItem->created_at->format('Y-m-d H:i:s') : null,
                ]
            ], 201);

        } catch (\Exception $e) {
            Log::error("Error creating room item: " . $e->getMessage(), ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating room item',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Put(path="/admin/room-items/{id}", tags={"Admin"}, summary="Update room item",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(in="path", name="id", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(@OA\JsonContent(@OA\Property(property="item_name", type="string"), @OA\Property(property="quantity", type="integer"), @OA\Property(property="description", type="string"))),
     *     @OA\Response(response=200, description="Updated", @OA\JsonContent(@OA\Property(property="success", type="boolean"), @OA\Property(property="message", type="string"), @OA\Property(property="data", type="object"))),
     *     @OA\Response(response=401, description="Unauthorized"), @OA\Response(response=404, description="Not found"), @OA\Response(response=422, description="Validation failed"), @OA\Response(response=500, description="Server error"))
     */
    public function updateRoomItem(Request $request, $itemId)
    {
        try {
            $validator = Validator::make($request->all(), [
                'item_name' => 'nullable|string|max:255',
                'item_description' => 'nullable|string|max:500',
                'quantity' => 'nullable|integer|min:1',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $roomItem = BnbRoomItem::find($itemId);
            if (!$roomItem) {
                return response()->json([
                    'success' => false,
                    'message' => 'Room item not found'
                ], 404);
            }

            $updateData = [];
            if ($request->has('item_name')) {
                $updateData['item_name'] = $request->item_name;
            }
            if ($request->has('item_description')) {
                $updateData['item_description'] = $request->item_description;
            }
            if ($request->has('quantity')) {
                $updateData['quantity'] = $request->quantity;
            }

            $roomItem->update($updateData);

            return response()->json([
                'success' => true,
                'message' => 'Room item updated successfully',
                'data' => [
                    'id' => $roomItem->id,
                    'bnb_room_id' => $roomItem->bnbroomid,
                    'item_name' => $roomItem->name,
                    'item_description' => $roomItem->description,
                    'created_at' => $roomItem->created_at ? $roomItem->created_at->format('Y-m-d H:i:s') : null,
                ]
            ], 200);

        } catch (\Exception $e) {
            Log::error("Error updating room item: " . $e->getMessage(), ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating room item',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Delete(path="/admin/room-items/{id}", tags={"Admin"}, summary="Delete room item",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(in="path", name="id", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Deleted", @OA\JsonContent(@OA\Property(property="success", type="boolean"), @OA\Property(property="message", type="string"))),
     *     @OA\Response(response=401, description="Unauthorized"), @OA\Response(response=404, description="Not found"), @OA\Response(response=500, description="Server error"))
     */
    public function deleteRoomItem($itemId)
    {
        try {
            $roomItem = BnbRoomItem::find($itemId);
            if (!$roomItem) {
                return response()->json([
                    'success' => false,
                    'message' => 'Room item not found'
                ], 404);
            }

            $roomItem->delete();

            return response()->json([
                'success' => true,
                'message' => 'Room item deleted successfully'
            ], 200);

        } catch (\Exception $e) {
            Log::error("Error deleting room item: " . $e->getMessage(), ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting room item',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
