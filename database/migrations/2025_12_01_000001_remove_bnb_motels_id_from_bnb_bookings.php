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
        Schema::table('bnb_bookings', function (Blueprint $table) {
            // Drop foreign key constraint first
            $table->dropForeign(['bnb_motels_id']);
            // Drop the column
            $table->dropColumn('bnb_motels_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bnb_bookings', function (Blueprint $table) {
            // Add the column back
            $table->unsignedBigInteger('bnb_motels_id')->nullable()->after('bnb_room_id');
            // Add foreign key constraint back
            $table->foreign('bnb_motels_id')->references('id')->on('bnb_motels')->onDelete('cascade');
        });
    }
};
