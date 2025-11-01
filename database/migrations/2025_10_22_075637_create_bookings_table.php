<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('title', 4);
            $table->string('first_name', 25);
            $table->string('last_name', 25);
            $table->string('full_name', 60)->index();
            $table->string('email', 60);
            $table->string('phone', 20);
            $table->string('room_type', 25);
            $table->string('room_image')->nullable();
            $table->date('check_in');
            $table->date('check_out');
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('bookings');
    }
};
