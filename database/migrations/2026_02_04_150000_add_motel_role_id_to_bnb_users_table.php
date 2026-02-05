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
            $table->unsignedBigInteger('motel_role_id')->nullable()->after('motel_id');
            $table->foreign('motel_role_id')->references('id')->on('motel_roles')->onDelete('set null');
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
            $table->dropForeign(['motel_role_id']);
            $table->dropColumn('motel_role_id');
        });
    }
};
