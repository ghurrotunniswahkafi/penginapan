<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'title','first_name','last_name','full_name',
        'email','phone','room_type','room_image',
        'check_in','check_out','check_in_time','check_out_time',
    ];
}
