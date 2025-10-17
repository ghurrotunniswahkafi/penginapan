<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Pengunjung;
use App\Models\Kamar;

class PengunjungController extends Controller
{
    public function __construct(){ $this->middleware('admin.auth'); }

    public function index(){
        $pengunjungs = Pengunjung::latest()->get();
        return view('admin.pengunjung.index', compact('pengunjungs'));
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

    public function destroy(Pengunjung $pengunjung){
        $pengunjung->delete();
        return back()->with('success','Pengunjung dihapus');
    }
}
