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
        Schema::table('bnb_rules', function (Blueprint $table) {
            $table->unsignedBigInteger('posted_by')->nullable()->after('motel_id');
            $table->foreign('posted_by')->references('id')->on('bnb_users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bnb_rules', function (Blueprint $table) {
            $table->dropForeign(['posted_by']);
            $table->dropColumn('posted_by');
        });
    }
};
