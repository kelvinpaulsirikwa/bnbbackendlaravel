<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('admin_logs', function (Blueprint $table) {
            $table->string('subject_type', 100)->nullable()->after('url')->comment('e.g. country, user, amenity');
            $table->unsignedBigInteger('subject_id')->nullable()->after('subject_type');
            $table->text('description')->nullable()->after('subject_id')->comment('Human-readable what changed');
            $table->json('old_values')->nullable()->after('request_data');
            $table->json('new_values')->nullable()->after('old_values');
        });
    }

    public function down(): void
    {
        Schema::table('admin_logs', function (Blueprint $table) {
            $table->dropColumn(['subject_type', 'subject_id', 'description', 'old_values', 'new_values']);
        });
    }
};
