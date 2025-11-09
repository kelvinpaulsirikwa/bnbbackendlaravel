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
        Schema::table('bnb_users', function (Blueprint $table) {
            $table->unsignedBigInteger('motel_id')->nullable()->after('role');
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
        Schema::table('bnb_users', function (Blueprint $table) {
            $table->dropForeign(['motel_id']);
            $table->dropColumn('motel_id');
        });
    }
};
