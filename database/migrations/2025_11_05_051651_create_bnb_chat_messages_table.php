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
        Schema::create('bnb_chat_messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('chat_id'); // FK to bnb_chats.id
            $table->enum('sender_type', ['customer', 'bnbuser'])->default('customer');
            $table->unsignedBigInteger('sender_id')->nullable(); // Refers to customers.id or bnb_users.id
            $table->text('message')->nullable();
            $table->enum('read_status', ['read', 'unread'])->default('unread');
            $table->timestamp('created_at')->useCurrent();

            // Foreign key constraints
            $table->foreign('chat_id')->references('id')->on('bnb_chats');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bnb_chat_messages');
    }
};
