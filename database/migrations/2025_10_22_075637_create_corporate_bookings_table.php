<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('corporate_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('full_name', 60);
            $table->string('email', 60);
            $table->string('phone_number', 20);
            $table->string('nama_kegiatan', 80);
            $table->string('nama_pic', 60);
            $table->string('telepon_pic', 20);
            $table->string('asal_persyarikatan', 80);
            $table->date('tanggal_persyarikatan');
            $table->unsignedInteger('jumlah_peserta');
            $table->unsignedInteger('jumlah_kasur'); // = jumlah kamar pada UI
            $table->string('room_type', 25)->default('Deluxe Room');
            $table->string('room_image')->nullable();
            $table->date('check_in');
            $table->string('check_in_time', 5)->default('12:00');
            $table->date('check_out');
            $table->string('check_out_time', 5)->default('12:00');
            $table->string('special_request', 255)->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('corporate_bookings');
    }
};
