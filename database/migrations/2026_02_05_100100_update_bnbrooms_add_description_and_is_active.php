<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bnbrooms', function (Blueprint $table) {
            if (!Schema::hasColumn('bnbrooms', 'description')) {
                $table->text('description')->nullable()->after('frontimage');
            }

            if (!Schema::hasColumn('bnbrooms', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('status');
            }
        });

        // Update status enum to use 'maintenance' instead of the old typo
        DB::statement("ALTER TABLE `bnbrooms` MODIFY `status` ENUM('free','booked','maintenance') DEFAULT 'free'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bnbrooms', function (Blueprint $table) {
            if (Schema::hasColumn('bnbrooms', 'description')) {
                $table->dropColumn('description');
            }

            if (Schema::hasColumn('bnbrooms', 'is_active')) {
                $table->dropColumn('is_active');
            }
        });

        // Optional: you can revert the enum definition here if needed
        // DB::statement(\"ALTER TABLE `bnbrooms` MODIFY `status` ENUM('booked','free','maintainace') DEFAULT 'free'\");
    }
};

