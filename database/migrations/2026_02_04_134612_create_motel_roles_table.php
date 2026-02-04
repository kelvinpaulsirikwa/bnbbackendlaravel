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
        Schema::create('motel_roles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('motel_id');
            $table->string('name');
            $table->json('permissions')->nullable();
            $table->timestamps();
            $table->foreign('motel_id')->references('id')->on('bnb_motels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('motel_roles');
    }
};
