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
        Schema::create('bnb_amenities_image', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bnb_amenities_id');
            $table->string('filepath');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('posted_by');
            $table->timestamps();

            $table->foreign('bnb_amenities_id')->references('id')->on('bnb_amenities');
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
        Schema::dropIfExists('bnb_amenities_image');
    }
};
