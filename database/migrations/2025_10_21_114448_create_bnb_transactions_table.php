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
        Schema::create('bnb_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id'); // Foreign key to bnb_bookings table
            $table->string('transaction_id')->unique(); // Unique transaction reference
            $table->decimal('amount', 10, 2);
            $table->enum('payment_method', ['mobile', 'bank_card', 'cash']);
            $table->string('payment_reference')->nullable(); // Mobile number or card reference
            $table->enum('status', ['pending', 'completed', 'failed', 'refunded'])->default('pending');
            $table->text('payment_details')->nullable(); // JSON field for additional payment info
            $table->string('gateway_response')->nullable(); // Response from payment gateway
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
            
            // Foreign key constraints
            $table->foreign('booking_id')->references('id')->on('bnb_bookings')->onDelete('cascade');
            
            // Indexes
            $table->index(['transaction_id']);
            $table->index(['booking_id']);
            $table->index(['status', 'processed_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bnb_transactions');
    }
};