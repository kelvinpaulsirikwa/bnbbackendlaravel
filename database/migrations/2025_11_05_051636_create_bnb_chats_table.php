<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bnb_chats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id'); // Links to bnb_bookings.id
            $table->unsignedBigInteger('motel_id'); // Links to bnb_motels.id
            $table->unsignedBigInteger('customer_id'); // Links to customers.id
            $table->enum('started_by', ['customer', 'bnbuser'])->default('customer');
            $table->enum('status', ['active', 'closed'])->default('active');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('booking_id')->references('id')->on('bnb_bookings');
            $table->foreign('motel_id')->references('id')->on('bnb_motels');
            $table->foreign('customer_id')->references('id')->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bnb_chats');
    }
};
