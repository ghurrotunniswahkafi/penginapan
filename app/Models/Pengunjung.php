<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengunjung extends Model
{
    use HasFactory;
    protected $fillable = [
      'nama','no_identitas','jenis_tamu','check_in','check_out','nomor_kamar',
      'asal_persyarikatan','nama_kegiatan','nama_pic','no_telp_pic',
      'jumlah_peserta','jumlah_kamar','special_request'
    ];
}
