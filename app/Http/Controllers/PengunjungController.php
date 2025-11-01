<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Pengunjung;
use App\Models\Kamar;

class PengunjungController extends Controller
{
    public function __construct(){
        $this->middleware(\App\Http\Middleware\AdminAuth::class);
    }

    public function index(){
        $pengunjungs = Pengunjung::latest()->get();
        return view('admin.pengunjung', compact('pengunjungs'));
    }

    public function create(){
        $kamars = Kamar::where('status','kosong')->get();
        return view('admin.pengunjung.create', compact('kamars'));
    }

    public function store(Request $r){
        $r->validate(['nama'=>'required']);
        Pengunjung::create($r->all());
        return redirect()->route('pengunjung.index')->with('success','Data pengunjung ditambah');
    }

    public function destroy($id){
        $pengunjung = Pengunjung::findOrFail($id);
        $pengunjung->delete();
        return back()->with('success','Pengunjung dihapus');
    }
}
