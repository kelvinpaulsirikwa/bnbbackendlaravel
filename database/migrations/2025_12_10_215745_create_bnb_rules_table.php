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
        Schema::create('bnb_rules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('motel_id');
            $table->text('rules')->nullable();
            $table->timestamps();
            
            $table->foreign('motel_id')->references('id')->on('bnb_motels')->onDelete('cascade');
            $table->unique('motel_id'); // One rule per motel
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bnb_rules');
    }
};
