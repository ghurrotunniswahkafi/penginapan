<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Kamar;
use App\Models\Pengunjung;

class AdminController extends Controller
{
    public function __construct()
    {
        // pakai FQCN langsung agar tidak tergantung alias di Kernel
        $this->middleware(\App\Http\Middleware\AdminAuth::class);
    }

    public function dashboard()
    {
        $totalKamar = Kamar::count();
        $kamarKosong = Kamar::where('status','kosong')->count();
        $jumlahPengunjung = Pengunjung::count();
        // untuk 4-kisi tampilan: kita bisa kirim stats
        return view('admin.dashboard', compact('totalKamar','kamarKosong','jumlahPengunjung'));
    }
}
