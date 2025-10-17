<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Pengunjung;
use App\Models\Kamar;

class BookingController extends Controller
{
    public function __construct(){ $this->middleware('admin.auth'); }

    public function corporate(){
        $kamars = Kamar::where('status','kosong')->get();
        return view('admin.booking.corporate', compact('kamars'));
    }

    public function storeCorporate(Request $r){
        $r->validate([
            'nama'=>'required',
            'check_in'=>'required|date',
            'check_out'=>'required|date|after_or_equal:check_in'
        ]);
        $data = $r->all();
        $data['jenis_tamu'] = 'corporate';
        Pengunjung::create($data);
        return redirect()->route('pengunjung.index')->with('success','Booking corporate tersimpan');
    }

    public function individu(){
        $kamars = Kamar::where('status','kosong')->get();
        return view('admin.booking.individu', compact('kamars'));
    }

    public function storeIndividu(Request $r){
        $r->validate([
            'nama'=>'required','check_in'=>'required','check_out'=>'required'
        ]);
        $data = $r->all();
        $data['jenis_tamu'] = 'individu';
        Pengunjung::create($data);
        return redirect()->route('pengunjung.index')->with('success','Booking individu tersimpan');
    }
}
