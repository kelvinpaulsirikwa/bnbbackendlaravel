<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop existing trigger if it exists
        DB::unprepared('DROP TRIGGER IF EXISTS update_room_status_after_insert');

        // Create trigger to update room status based on future booking dates
        DB::unprepared("
            CREATE TRIGGER update_room_status_after_insert
            AFTER INSERT ON bnb_booking_dates
            FOR EACH ROW
            BEGIN
                DECLARE cnt INT;
                SELECT COUNT(*) INTO cnt
                FROM bnb_booking_dates
                WHERE bnb_room_id = NEW.bnb_room_id
                  AND booked_date >= CURDATE();

                UPDATE bnbrooms
                SET status = IF(cnt > 0, 'booked', 'free')
                WHERE id = NEW.bnb_room_id;
            END
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS update_room_status_after_insert');
    }
};

