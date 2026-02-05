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