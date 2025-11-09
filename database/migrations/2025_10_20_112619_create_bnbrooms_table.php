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
        Schema::create('bnbrooms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('motelid');
            $table->string('room_number');
            $table->unsignedBigInteger('room_type_id');
            $table->decimal('price_per_night', 10, 2)->default(0.00);
            $table->decimal('office_price_per_night', 10, 2)->default(0.00);
            $table->string('frontimage')->nullable();
            $table->enum('status', ['booked', 'free', 'maintainace'])->default('free');
            $table->unsignedBigInteger('created_by');
            $table->timestamps();

            $table->foreign('motelid')->references('id')->on('bnb_motels');
            $table->foreign('room_type_id')->references('id')->on('room_types');
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
        Schema::dropIfExists('bnbrooms');
    }
};
