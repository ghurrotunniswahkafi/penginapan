<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $t) {
            if (!Schema::hasColumn('bookings','full_name')) {
                $t->string('full_name',80)->nullable()->after('last_name');
            }
            if (!Schema::hasColumn('bookings','room_image')) {
                $t->string('room_image')->nullable()->after('room_type');
            }
            if (!Schema::hasColumn('bookings','check_in_time')) {
                $t->time('check_in_time')->nullable()->after('check_in');
            }
            if (!Schema::hasColumn('bookings','check_out_time')) {
                $t->time('check_out_time')->nullable()->after('check_out');
            }
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $t) {
            if (Schema::hasColumn('bookings','check_out_time')) $t->dropColumn('check_out_time');
            if (Schema::hasColumn('bookings','check_in_time'))  $t->dropColumn('check_in_time');
            if (Schema::hasColumn('bookings','room_image'))     $t->dropColumn('room_image');
            if (Schema::hasColumn('bookings','full_name'))      $t->dropColumn('full_name');
        });
    }
};
