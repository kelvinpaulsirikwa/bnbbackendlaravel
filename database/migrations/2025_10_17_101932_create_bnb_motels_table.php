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
        Schema::create('bnb_motels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('owner_id');
            $table->unsignedBigInteger('motel_type_id')->nullable();
            $table->string('street_address')->nullable();
            $table->unsignedBigInteger('district_id')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('front_image')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            $table->foreign('owner_id')->references('id')->on('bnb_users');
            $table->foreign('motel_type_id')->references('id')->on('motel_types');
            $table->foreign('created_by')->references('id')->on('bnb_users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bnb_motels');
    }
};
