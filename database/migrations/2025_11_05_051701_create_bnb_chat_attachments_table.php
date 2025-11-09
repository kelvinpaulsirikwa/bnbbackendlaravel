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
        Schema::create('bnb_chat_attachments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('message_id'); // FK to bnb_chat_messages.id
            $table->string('file_path', 255); // Path or URL to file
            $table->string('file_type', 50)->default('image'); // image, pdf, doc, video, etc.
            $table->unsignedBigInteger('uploaded_by')->nullable(); // bnb_users.id or customers.id
            $table->timestamp('uploaded_at')->useCurrent();

            // Foreign key constraints
            $table->foreign('message_id')->references('id')->on('bnb_chat_messages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bnb_chat_attachments');
    }
};
