<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bnb_booking_dates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id');
            $table->unsignedBigInteger('bnb_room_id');
            $table->date('booked_date');
            $table->decimal('price_per_night', 10, 2)->nullable();
            $table->timestamps();

            $table->unique(['bnb_room_id', 'booked_date'], 'unique_room_date');

            $table->foreign('booking_id')
                ->references('id')
                ->on('bnb_bookings')
                ->onDelete('cascade');

            $table->foreign('bnb_room_id')
                ->references('id')
                ->on('bnbrooms')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bnb_booking_dates');
    }
};

