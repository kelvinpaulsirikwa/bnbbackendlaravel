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
        Schema::create('bnb_amenities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('amenities_id');
            $table->unsignedBigInteger('bnb_motels_id');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('posted_by');
            $table->timestamps();

            $table->foreign('amenities_id')->references('id')->on('amenities');
            $table->foreign('bnb_motels_id')->references('id')->on('bnb_motels');
            $table->foreign('posted_by')->references('id')->on('bnb_users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bnb_amenities');
    }
};
