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
        Schema::create('bnb_bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id'); // Foreign key to customers table
            $table->unsignedBigInteger('bnb_room_id'); // Foreign key to bnb_rooms table
            $table->unsignedBigInteger('bnb_motels_id'); // Foreign key to bnb_motels table
            $table->date('check_in_date');
            $table->date('check_out_date');
            $table->integer('number_of_nights');
            $table->decimal('price_per_night', 10, 2);
            $table->decimal('total_amount', 10, 2);
            $table->string('contact_number');
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'completed'])->default('pending');
            $table->text('special_requests')->nullable();
            $table->timestamps();
            
            // Foreign key constraints
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('bnb_room_id')->references('id')->on('bnbrooms')->onDelete('cascade');
            $table->foreign('bnb_motels_id')->references('id')->on('bnb_motels')->onDelete('cascade');
            
            // Indexes
            $table->index(['customer_id', 'status']);
            $table->index(['bnb_room_id', 'check_in_date', 'check_out_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bnb_bookings');
    }
};