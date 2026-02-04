<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('bnb_users', function (Blueprint $table) {
            $table->json('admin_permissions')->nullable()->after('role');
        });
    }

    public function down()
    {
        Schema::table('bnb_users', function (Blueprint $table) {
            $table->dropColumn('admin_permissions');
        });
    }
};
