<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Kamar;

class KamarController extends Controller
{
    public function __construct(){ $this->middleware('admin.auth'); }

    public function index(){
        $kamars = Kamar::orderBy('nomor_kamar')->get();
        return view('admin.kamar.index', compact('kamars'));
    }

    public function create(){ return view('admin.kamar.create'); }

    public function store(Request $r){
        $r->validate([
            'nomor_kamar'=>'required|unique:kamars,nomor_kamar',
            'jenis_kamar'=>'required','harga'=>'nullable|numeric'
        ]);
        Kamar::create($r->only(['nomor_kamar','jenis_kamar','gedung','harga','fasilitas','status']));
        return redirect()->route('kamar.index')->with('success','Kamar ditambahkan');
    }

    public function edit(Kamar $kamar){ return view('admin.kamar.edit', compact('kamar')); }

    public function update(Request $r, Kamar $kamar){
        $r->validate(['jenis_kamar'=>'required']);
        $kamar->update($r->only(['jenis_kamar','gedung','harga','fasilitas','status']));
        return redirect()->route('kamar.index')->with('success','Kamar diperbarui');
    }

    public function destroy(Kamar $kamar){
        $kamar->delete();
        return back()->with('success','Kamar dihapus');
    }
}
