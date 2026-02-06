<?php

namespace App\Http\Controllers\UserApi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BnbRoom;
use App\Models\RoomType;
use App\Models\BnbRoomImage;
use App\Models\BnbRoomItem;

class RoomApiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/motels/{id}/rooms",
     *     tags={"Rooms"},
     *     summary="Get motel rooms",
     *     description="Paginated rooms for a motel. Optional filters: status, room_type. Requires Bearer token.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(name="id", in="path", required=true, description="Motel ID", @OA\Schema(type="integer")),
     *     @OA\Parameter(name="page", in="query", @OA\Schema(type="integer", default=1)),
     *     @OA\Parameter(name="limit", in="query", @OA\Schema(type="integer", default=10)),
     *     @OA\Parameter(name="status", in="query", description="available|occupied|maintenance", @OA\Schema(type="string")),
     *     @OA\Parameter(name="room_type", in="query", description="Room type name", @OA\Schema(type="string")),
     *     @OA\Response(response=200, description="OK",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="data", type="array", @OA\Items(
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="roomnumber", type="string"),
     *                 @OA\Property(property="roomtype", type="string"),
     *                 @OA\Property(property="pricepernight", type="number"),
     *                 @OA\Property(property="officepricepernight", type="number", nullable=true),
     *                 @OA\Property(property="frontimage", type="string", nullable=true),
     *                 @OA\Property(property="status", type="string")
     *             )),
     *             @OA\Property(property="pagination", type="object", @OA\Property(property="current_page", type="string"), @OA\Property(property="per_page", type="string"), @OA\Property(property="total", type="integer"), @OA\Property(property="has_more", type="boolean")),
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(response=500, description="Server error")
     * )
     */
    public function getMotelRooms($motelId, Request $request)
    {
        try {
            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);
            $offset = ($page - 1) * $limit;

            $query = BnbRoom::where('motelid', $motelId);

            // Filter by status if provided
            if ($request->filled('status')) {
                // Map frontend status to database status
                $statusMap = [
                    'available' => 'free',
                    'occupied' => 'occupied',
                    'maintenance' => 'maintenance'
                ];
                $dbStatus = $statusMap[$request->status] ?? $request->status;
                $query->where('status', $dbStatus);
            }

            // Filter by room type if provided
            if ($request->filled('room_type')) {
                $query->whereHas('roomType', function($q) use ($request) {
                    $q->where('name', $request->room_type);
                });
            }

            $rooms = $query->with('roomType')
                          ->orderBy('created_at', 'desc')
                          ->offset($offset)
                          ->limit($limit)
                          ->get();

            $totalRooms = $query->count();
            $hasMore = ($offset + $limit) < $totalRooms;

            // Transform data to match Flutter Room model
            $transformedRooms = $rooms->map(function($room) {
                return [
                    'id' => $room->id,
                    'roomnumber' => $room->room_number,
                    'roomtype' => $room->roomType ? $room->roomType->name : 'Unknown Type',
                    'pricepernight' => $room->price_per_night,
                    'officepricepernight' => $room->office_price_per_night,
                    'frontimage' => $room->frontimage,
                    'status' => $room->status,
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $transformedRooms,
                'pagination' => [
                    'current_page' => (string) $page,
                    'per_page' => (string) $limit,
                    'total' => $totalRooms,
                    'has_more' => $hasMore,
                ],
                'message' => 'Rooms retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve rooms',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/motels/{id}/room-types",
     *     tags={"Rooms"},
     *     summary="Get motel room types",
     *     description="Unique room types used in this motel. Requires Bearer token.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(name="id", in="path", required=true, description="Motel ID", @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="OK",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="data", type="array", @OA\Items(type="object", description="RoomType with id, name, etc.")),
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(response=500, description="Server error")
     * )
     */
    public function getMotelRoomTypes($motelId)
    {
        try {
            // Get unique room types that exist in this motel
            $roomTypes = BnbRoom::where('motelid', $motelId)
                              ->with('roomType')
                              ->get()
                              ->pluck('roomType')
                              ->unique('id')
                              ->values();

            return response()->json([
                'success' => true,
                'data' => $roomTypes,
                'message' => 'Motel room types retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve motel room types',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/rooms/{id}/details",
     *     tags={"Rooms"},
     *     summary="Get room details",
     *     description="Single room with motel info. Requires Bearer token.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(name="id", in="path", required=true, description="Room ID", @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="OK",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="roomnumber", type="string"),
     *                 @OA\Property(property="roomtype", type="string"),
     *                 @OA\Property(property="pricepernight", type="number"),
     *                 @OA\Property(property="officepricepernight", type="number"),
     *                 @OA\Property(property="frontimage", type="string", nullable=true),
     *                 @OA\Property(property="status", type="string"),
     *                 @OA\Property(property="motel", type="object", @OA\Property(property="id", type="integer"), @OA\Property(property="name", type="string"), @OA\Property(property="street_address", type="string", nullable=true))
     *             ),
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Room not found"),
     *     @OA\Response(response=500, description="Server error")
     * )
     */
    public function getRoomDetails($roomId)
    {
        try {
            $room = BnbRoom::with('roomType', 'motel')
                          ->where('id', $roomId)
                          ->first();

            if (!$room) {
                return response()->json([
                    'success' => false,
                    'message' => 'Room not found'
                ], 404);
            }

            // Transform data to match Flutter Room model
            $transformedRoom = [
                'id' => $room->id,
                'roomnumber' => $room->room_number,
                'roomtype' => $room->roomType ? $room->roomType->name : 'Unknown Type',
                'pricepernight' => (float) $room->price_per_night,
                'officepricepernight' => (float) $room->office_price_per_night,
                'frontimage' => $room->frontimage,
                'status' => $room->status,
                'motel' => [
                    'id' => $room->motel->id,
                    'name' => $room->motel->name,
                    'street_address' => $room->motel->street_address,
                ],
            ];

            return response()->json([
                'success' => true,
                'data' => $transformedRoom,
                'message' => 'Room details retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve room details',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/rooms/{id}/images",
     *     tags={"Rooms"},
     *     summary="Get room images",
     *     description="Paginated room images. Requires Bearer token.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(name="id", in="path", required=true, description="Room ID", @OA\Schema(type="integer")),
     *     @OA\Parameter(name="page", in="query", @OA\Schema(type="integer", default=1)),
     *     @OA\Parameter(name="limit", in="query", @OA\Schema(type="integer", default=5)),
     *     @OA\Response(response=200, description="OK",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="data", type="array", @OA\Items(type="object", description="BnbRoomImage fields")),
     *             @OA\Property(property="pagination", type="object"),
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(response=500, description="Server error")
     * )
     */
    public function getRoomImages($roomId, Request $request)
    {
        try {
            $page = $request->get('page', 1);
            $limit = $request->get('limit', 5);
            $offset = ($page - 1) * $limit;

            $images = BnbRoomImage::where('bnbroomid', $roomId)
                                 ->orderBy('created_at', 'desc')
                                 ->offset($offset)
                                 ->limit($limit)
                                 ->get();

            $totalImages = BnbRoomImage::where('bnbroomid', $roomId)->count();
            $hasMore = ($offset + $limit) < $totalImages;

            return response()->json([
                'success' => true,
                'data' => $images,
                'pagination' => [
                    'current_page' => (string) $page,
                    'per_page' => (string) $limit,
                    'total' => $totalImages,
                    'has_more' => $hasMore,
                ],
                'message' => 'Room images retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve room images',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/rooms/{id}/items",
     *     tags={"Rooms"},
     *     summary="Get room items",
     *     description="Paginated room items (name, description). Requires Bearer token.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(name="id", in="path", required=true, description="Room ID", @OA\Schema(type="integer")),
     *     @OA\Parameter(name="page", in="query", @OA\Schema(type="integer", default=1)),
     *     @OA\Parameter(name="limit", in="query", @OA\Schema(type="integer", default=10)),
     *     @OA\Response(response=200, description="OK",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="data", type="array", @OA\Items(
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="bnbroomid", type="integer"),
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="description", type="string", nullable=true)
     *             )),
     *             @OA\Property(property="pagination", type="object"),
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(response=500, description="Server error")
     * )
     */
    public function getRoomItems($roomId, Request $request)
    {
        try {
            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);
            $offset = ($page - 1) * $limit;

            $items = BnbRoomItem::where('bnbroomid', $roomId)
                               ->orderBy('created_at', 'desc')
                               ->offset($offset)
                               ->limit($limit)
                               ->get();

            $totalItems = BnbRoomItem::where('bnbroomid', $roomId)->count();
            $hasMore = ($offset + $limit) < $totalItems;

            return response()->json([
                'success' => true,
                'data' => $items,
                'pagination' => [
                    'current_page' => (string) $page,
                    'per_page' => (string) $limit,
                    'total' => $totalItems,
                    'has_more' => $hasMore,
                ],
                'message' => 'Room items retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve room items',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}