<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CorporateBooking extends Model
{
    protected $fillable = [
        'full_name','email','phone_number','nama_kegiatan','nama_pic','telepon_pic',
        'asal_persyarikatan','tanggal_persyarikatan','jumlah_peserta','jumlah_kasur',
        'room_type','room_image','check_in','check_in_time','check_out','check_out_time',
        'special_request'
    ];
}
