<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hotel_owner_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_user_id')->constrained('bnb_users')->cascadeOnDelete();
            $table->string('action', 255)->comment('Human-readable action description');
            $table->string('method', 10)->comment('HTTP method: GET, POST, PUT, PATCH, DELETE');
            $table->string('route_name', 255)->nullable();
            $table->string('url', 1024);
            $table->string('subject_type', 100)->nullable();
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->text('description')->nullable()->comment('Human-readable what changed');
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->json('request_data')->nullable();
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->timestamps();
        });

        Schema::table('hotel_owner_logs', function (Blueprint $table) {
            $table->index(['owner_user_id', 'created_at']);
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hotel_owner_logs');
    }
};
