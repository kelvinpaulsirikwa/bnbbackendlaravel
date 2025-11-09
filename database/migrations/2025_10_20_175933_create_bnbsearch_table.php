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
        Schema::create('bnbsearch', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bnb_motels_id');
            $table->integer('count')->default(1);
            $table->timestamps();
            
            // Foreign key constraint
            $table->foreign('bnb_motels_id')->references('id')->on('bnb_motels')->onDelete('cascade');
            
            // Unique constraint to prevent duplicate entries for same motel
            $table->unique('bnb_motels_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bnbsearch');
    }
};
