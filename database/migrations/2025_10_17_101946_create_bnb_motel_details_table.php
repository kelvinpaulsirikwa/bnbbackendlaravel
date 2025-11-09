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
        Schema::create('bnb_motel_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('motel_id');
            $table->string('contact_phone', 20)->nullable();
            $table->string('contact_email', 100)->nullable();
            $table->integer('total_rooms')->default(0);
            $table->integer('available_rooms')->default(0);
            $table->enum('status', ['active', 'inactive', 'closed'])->default('active');
            $table->timestamps();

            $table->foreign('motel_id')->references('id')->on('bnb_motels');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bnb_motel_details');
    }
};
