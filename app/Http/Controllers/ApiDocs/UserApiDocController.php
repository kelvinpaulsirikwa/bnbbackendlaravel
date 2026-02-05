<?php

namespace App\Http\Controllers\ApiDocs;

/**
 * @OA\OpenApi(
 *     openapi="3.0.0",
 *     info={
 *         "title": "User API (BnB)",
 *         "version": "1.0.0",
 *         "description": "API for BnB app: login, regions, motels, rooms, booking, chat. Protected routes require Bearer token (Sanctum)."
 *     },
 *     servers={
 *         {"url": "http://localhost:8000/api", "description": "Local"},
 *         {"url": "https://bnb.co.tz/api", "description": "Production"}
 *     },
 *     security={{"sanctum": {}}}
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="sanctum",
 *     type="apiKey",
 *     in="header",
 *     name="Authorization",
 *     description="Bearer {token}"
 * )
 */
class UserApiDocController
{
    // ==================== PUBLIC ====================

    /**
     * @OA\Post(
     *     path="/userlogin",
     *     tags={"Auth"},
     *     summary="Login (Google / email)",
     *     security={},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email"},
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *             @OA\Property(property="username", type="string", example="John Doe"),
     *             @OA\Property(property="userimage", type="string", example="https://..."),
     *             @OA\Property(property="phone", type="string", example="+255...")
     *         )
     *     ),
     *     @OA\Response(response=200, description="OK",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Login successful"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="user", type="object",
     *                     @OA\Property(property="id", type="integer"),
     *                     @OA\Property(property="username", type="string"),
     *                     @OA\Property(property="useremail", type="string"),
     *                     @OA\Property(property="userimage", type="string", nullable=true),
     *                     @OA\Property(property="phonenumber", type="string", nullable=true)
     *                 ),
     *                 @OA\Property(property="token", type="string"),
     *                 @OA\Property(property="token_type", type="string", example="Bearer")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=422, description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Validation error"),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     )
     * )
     */
    public function userlogin() {}

    // ==================== PROTECTED (auth:sanctum) ====================

    /**
     * @OA\Get(
     *     path="/user",
     *     tags={"Auth"},
     *     summary="Get authenticated user",
     *     @OA\Response(response=200, description="Authenticated user object")
     * )
     */
    public function user() {}

    /**
     * @OA\Post(
     *     path="/logout",
     *     tags={"Auth"},
     *     summary="Logout (invalidate token)",
     *     @OA\Response(response=200, description="Success")
     * )
     */
    public function logout() {}

    /**
     * @OA\Get(
     *     path="/regions",
     *     tags={"Location"},
     *     summary="List regions",
     *     @OA\Parameter(name="country_id", in="query", required=false, @OA\Schema(type="integer")),
     *     @OA\Parameter(name="search", in="query", required=false, @OA\Schema(type="string")),
     *     @OA\Response(response=200, description="OK",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array", @OA\Items(type="object")),
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function regions() {}

    /**
     * @OA\Get(
     *     path="/districts",
     *     tags={"Location"},
     *     summary="List districts",
     *     @OA\Response(response=200, description="OK",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="data", type="array", @OA\Items(type="object"))
     *         )
     *     )
     * )
     */
    public function districts() {}

    /**
     * @OA\Get(
     *     path="/motel-types",
     *     tags={"Motels"},
     *     summary="List motel types",
     *     @OA\Response(response=200, description="OK",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="data", type="array", @OA\Items(type="object"))
     *         )
     *     )
     * )
     */
    public function motelTypes() {}

    /**
     * @OA\Get(
     *     path="/motels",
     *     tags={"Motels"},
     *     summary="List motels",
     *     @OA\Response(response=200, description="OK",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="data", type="array", @OA\Items(type="object"))
     *         )
     *     )
     * )
     */
    public function motels() {}

    /**
     * @OA\Get(
     *     path="/motels/featured",
     *     tags={"Motels"},
     *     summary="Featured motels",
     *     @OA\Response(response=200, description="OK",
     *         @OA\JsonContent(@OA\Property(property="success", type="boolean"), @OA\Property(property="data", type="array", @OA\Items(type="object")))
     *     )
     * )
     */
    public function motelsFeatured() {}

    /**
     * @OA\Get(
     *     path="/motels/{id}/details",
     *     tags={"Motels"},
     *     summary="Motel details",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="OK",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     )
     * )
     */
    public function motelDetails() {}

    /**
     * @OA\Get(
     *     path="/motels/{id}/images",
     *     tags={"Motels"},
     *     summary="Motel images",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function motelImages() {}

    /**
     * @OA\Get(
     *     path="/user/motels/{motelId}/images",
     *     tags={"Motels"},
     *     summary="Motel images (paged)",
     *     @OA\Parameter(name="motelId", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function motelImagesPaging() {}

    /**
     * @OA\Get(
     *     path="/motels/{id}/amenities",
     *     tags={"Motels"},
     *     summary="Motel amenities",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function motelAmenities() {}

    /**
     * @OA\Get(
     *     path="/amenities/{bnbamenitiesid}/amenitiesimage",
     *     tags={"Motels"},
     *     summary="Amenity images",
     *     @OA\Parameter(name="bnbamenitiesid", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function amenitiesImage() {}

    /**
     * @OA\Get(
     *     path="/motels/{id}/rules",
     *     tags={"Motels"},
     *     summary="Motel rules (BnB rules)",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function motelRules() {}

    /**
     * @OA\Get(
     *     path="/motels/{id}/rooms",
     *     tags={"Rooms"},
     *     summary="Motel rooms",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function motelRooms() {}

    /**
     * @OA\Get(
     *     path="/motels/{id}/room-types",
     *     tags={"Rooms"},
     *     summary="Motel room types",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function motelRoomTypes() {}

    /**
     * @OA\Get(
     *     path="/rooms/{id}/details",
     *     tags={"Rooms"},
     *     summary="Room details",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function roomDetails() {}

    /**
     * @OA\Get(
     *     path="/rooms/{id}/images",
     *     tags={"Rooms"},
     *     summary="Room images",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function roomImages() {}

    /**
     * @OA\Get(
     *     path="/rooms/{id}/items",
     *     tags={"Rooms"},
     *     summary="Room items",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function roomItems() {}

    /**
     * @OA\Get(
     *     path="/search/regions",
     *     tags={"Search"},
     *     summary="Search regions",
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function searchRegions() {}

    /**
     * @OA\Get(
     *     path="/search/amenities",
     *     tags={"Search"},
     *     summary="Search amenities",
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function searchAmenities() {}

    /**
     * @OA\Get(
     *     path="/search/motels",
     *     tags={"Search"},
     *     summary="Search motels",
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function searchMotels() {}

    /**
     * @OA\Get(
     *     path="/search/motels/{id}/images",
     *     tags={"Search"},
     *     summary="Motel images (search)",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function searchMotelImages() {}

    /**
     * @OA\Post(
     *     path="/search/track",
     *     tags={"Search"},
     *     summary="Track search",
     *     @OA\RequestBody(@OA\JsonContent(type="object")),
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function searchTrack() {}

    /**
     * @OA\Get(
     *     path="/near-me/motels",
     *     tags={"Near Me"},
     *     summary="Motels near me",
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function nearMeMotels() {}

    /**
     * @OA\Get(
     *     path="/top-searched/motels",
     *     tags={"Near Me"},
     *     summary="Top searched motels",
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function topSearchedMotels() {}

    /**
     * @OA\Get(
     *     path="/newest/motels",
     *     tags={"Near Me"},
     *     summary="Newest motels",
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function newestMotels() {}

    /**
     * @OA\Post(
     *     path="/check-room-availability",
     *     tags={"Booking"},
     *     summary="Check room availability",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"room_id","check_in_date","check_out_date"},
     *             @OA\Property(property="room_id", type="integer", example=1),
     *             @OA\Property(property="check_in_date", type="string", format="date", example="2025-02-10"),
     *             @OA\Property(property="check_out_date", type="string", format="date", example="2025-02-12")
     *         )
     *     ),
     *     @OA\Response(response=200, description="OK",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="available", type="boolean"),
     *                 @OA\Property(property="message", type="string")
     *             )
     *         )
     *     )
     * )
     */
    public function checkRoomAvailability() {}

    /**
     * @OA\Post(
     *     path="/create-booking",
     *     tags={"Booking"},
     *     summary="Create booking and process payment",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"room_id","customer_id","check_in_date","check_out_date","contact_number"},
     *             @OA\Property(property="room_id", type="integer", example=1),
     *             @OA\Property(property="customer_id", type="integer", example=1),
     *             @OA\Property(property="check_in_date", type="string", format="date", example="2025-02-10"),
     *             @OA\Property(property="check_out_date", type="string", format="date", example="2025-02-12"),
     *             @OA\Property(property="contact_number", type="string", example="+255670000000")
     *         )
     *     ),
     *     @OA\Response(response=200, description="OK",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="booking_id", type="integer"),
     *                 @OA\Property(property="total_amount", type="number"),
     *                 @OA\Property(property="payment_status", type="string")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=422, description="Validation / conflict",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function createBooking() {}

    /**
     * @OA\Post(
     *     path="/retry-payment/{bookingId}",
     *     tags={"Booking"},
     *     summary="Retry payment for booking",
     *     @OA\Parameter(name="bookingId", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function retryPayment() {}

    /**
     * @OA\Get(
     *     path="/booking/{bookingId}",
     *     tags={"Booking"},
     *     summary="Get booking details",
     *     @OA\Parameter(name="bookingId", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="OK",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     )
     * )
     */
    public function getBookingDetails() {}

    /**
     * @OA\Post(
     *     path="/cancel-booking/{bookingId}",
     *     tags={"Booking"},
     *     summary="Cancel booking",
     *     @OA\Parameter(name="bookingId", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function cancelBooking() {}

    /**
     * @OA\Post(
     *     path="/booking/create",
     *     tags={"Booking (Legacy)"},
     *     summary="Create booking (legacy)",
     *     @OA\RequestBody(@OA\JsonContent(type="object")),
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function bookingCreate() {}

    /**
     * @OA\Get(
     *     path="/booking/customer/{customer_id}",
     *     tags={"Booking (Legacy)"},
     *     summary="Customer bookings",
     *     @OA\Parameter(name="customer_id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function getCustomerBookings() {}

    /**
     * @OA\Get(
     *     path="/booking/customer/{customer_id}/transactions",
     *     tags={"Booking (Legacy)"},
     *     summary="Customer transactions",
     *     @OA\Parameter(name="customer_id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function getCustomerTransactions() {}

    /**
     * @OA\Post(
     *     path="/booking/cancel",
     *     tags={"Booking (Legacy)"},
     *     summary="Cancel booking (legacy)",
     *     @OA\RequestBody(@OA\JsonContent(type="object")),
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function bookingCancel() {}

    /**
     * @OA\Get(
     *     path="/about/statistics",
     *     tags={"About"},
     *     summary="BnB statistics",
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function aboutStatistics() {}

    /**
     * @OA\Get(
     *     path="/about/amenities",
     *     tags={"About"},
     *     summary="About amenities",
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function aboutAmenities() {}

    /**
     * @OA\Get(
     *     path="/customer/chats",
     *     tags={"Chat"},
     *     summary="Customer chats",
     *     @OA\Response(response=200, description="OK",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="data", type="array", @OA\Items(type="object"))
     *         )
     *     )
     * )
     */
    public function customerChats() {}

    /**
     * @OA\Get(
     *     path="/chat/{chatId}/messages",
     *     tags={"Chat"},
     *     summary="Chat messages",
     *     @OA\Parameter(name="chatId", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function chatMessages() {}

    /**
     * @OA\Post(
     *     path="/chat/send-message",
     *     tags={"Chat"},
     *     summary="Send message",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"chat_id","message"},
     *             @OA\Property(property="chat_id", type="integer"),
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function chatSendMessage() {}

    /**
     * @OA\Post(
     *     path="/chat/create-or-get",
     *     tags={"Chat"},
     *     summary="Create or get chat",
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="motel_id", type="integer"),
     *             @OA\Property(property="customer_id", type="integer")
     *         )
     *     ),
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function chatCreateOrGet() {}
}
