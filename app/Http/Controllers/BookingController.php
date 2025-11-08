<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Pengunjung;
use App\Models\Kamar;

class BookingController extends Controller
{
    public function __construct(){
        // use FQCN middleware
        $this->middleware(\App\Http\Middleware\AdminAuth::class);
    }

    public function corporate(){
        $kamars = Kamar::where('status','kosong')->get();
        return view('admin.booking.corporate', compact('kamars'));
    }

    public function storeCorporate(Request $r){
        $r->validate([
            'nama'=>'required',
            'nama_kegiatan'=>'required',
            'nama_pic'=>'required',
            'no_telp_pic'=>'required',
            'asal_persyarikatan'=>'required',
            'check_in'=>'required|date',
            'check_out'=>'required|date|after_or_equal:check_in',
            'jumlah_peserta'=>'required|integer|min:1',
            'jumlah_kamar'=>'required|integer|min:1',
            'kode_kamar'=>'nullable|string',
        ]);

        // VALIDASI: Cek duplikasi booking kamar pada tanggal yang sama
        if ($r->filled('kode_kamar')) {
            $kamarIds = explode(',', $r->kode_kamar);
            
            foreach ($kamarIds as $kamar) {
                $conflict = Pengunjung::where(function($q) use ($kamar) {
                        $q->where('kode_kamar', 'like', '%' . trim($kamar) . '%')
                          ->orWhere('nomor_kamar', 'like', '%' . trim($kamar) . '%');
                    })
                    ->where(function($q) use ($r) {
                        $q->whereBetween('check_in', [$r->check_in, $r->check_out])
                          ->orWhereBetween('check_out', [$r->check_in, $r->check_out])
                          ->orWhere(function($query) use ($r) {
                              $query->where('check_in', '<=', $r->check_in)
                                    ->where('check_out', '>=', $r->check_out);
                          });
                    })
                    ->whereNotIn('payment_status', ['rejected'])
                    ->exists();

                if ($conflict) {
                    return back()->withErrors([
                        'kode_kamar' => "❌ Kamar {$kamar} sudah dibooking pada tanggal {$r->check_in} sampai {$r->check_out}. Silakan pilih kamar atau tanggal lain."
                    ])->withInput();
                }
            }
        }

        $data = $r->only([
            'nama','nama_kegiatan','nama_pic','no_telp_pic','asal_persyarikatan',
            'check_in','check_out','jumlah_peserta','jumlah_kamar','special_request',
            'kebutuhan_snack','kebutuhan_makan','kode_kamar'
        ]);
        $data['jenis_tamu'] = 'corporate';
        $data['payment_status'] = 'pending';
        Pengunjung::create($data);
        return redirect()->route('pengunjung.index')->with('success','Booking corporate tersimpan');
    }

    public function individu(){
        $kamars = Kamar::where('status','kosong')->get();
        return view('admin.booking_individu', compact('kamars'));
    }

    public function storeIndividu(Request $r){
        $r->validate([
            'nama'=>'required',
            'no_identitas'=>'required',
            'check_in'=>'required|date',
            'check_out'=>'required|date|after_or_equal:check_in',
            'kode_kamar'=>'nullable|string',
        ]);

        // VALIDASI: Cek duplikasi booking kamar pada tanggal yang sama
        if ($r->filled('kode_kamar')) {
            $kamarIds = explode(',', $r->kode_kamar);
            
            foreach ($kamarIds as $kamar) {
                $conflict = Pengunjung::where(function($q) use ($kamar) {
                        $q->where('kode_kamar', 'like', '%' . trim($kamar) . '%')
                          ->orWhere('nomor_kamar', 'like', '%' . trim($kamar) . '%');
                    })
                    ->where(function($q) use ($r) {
                        $q->whereBetween('check_in', [$r->check_in, $r->check_out])
                          ->orWhereBetween('check_out', [$r->check_in, $r->check_out])
                          ->orWhere(function($query) use ($r) {
                              $query->where('check_in', '<=', $r->check_in)
                                    ->where('check_out', '>=', $r->check_out);
                          });
                    })
                    ->whereNotIn('payment_status', ['rejected'])
                    ->exists();

                if ($conflict) {
                    return back()->withErrors([
                        'kode_kamar' => "❌ Kamar {$kamar} sudah dibooking pada tanggal {$r->check_in} sampai {$r->check_out}. Silakan pilih kamar atau tanggal lain."
                    ])->withInput();
                }
            }
        }

        $data = $r->only(['nama','no_identitas','identity_type','no_telp','check_in','check_out','kode_kamar','special_request']);
        // ensure identity_type provided
        if (empty($data['identity_type'])) {
            return back()->withErrors(['identity_type' => 'Tipe identitas wajib dipilih (KTP/KTM/SIM).'])->withInput();
        }
        $data['jenis_tamu'] = 'individu';
        $data['payment_status'] = 'pending';
        Pengunjung::create($data);
        return redirect()->route('pengunjung.index')->with('success','Booking individu tersimpan');
    }

    // Show public booking form for users
    public function showBookingForm()
    {
        // Get available room types with count
        $jenisKamarList = Kamar::where('status', 'kosong')
            ->select('jenis_kamar', 'gedung', 'harga', 'fasilitas')
            ->selectRaw('COUNT(*) as available_count')
            ->groupBy('jenis_kamar', 'gedung', 'harga', 'fasilitas')
            ->get();
        
        return view('booking_form', compact('jenisKamarList'));
    }

    // Handle booking submission from users
    public function submitBooking(Request $r)
    {
        $rules = [
            'jenis_tamu' => 'required|in:Individu,Corporate',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'jenis_kamar_pilihan' => 'required',
            'bukti_pembayaran' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ];

        if ($r->jenis_tamu == 'Individu') {
            $rules['nama'] = 'required';
            $rules['no_identitas'] = 'required';
            $rules['identity_type'] = 'required';
            $rules['no_telp'] = 'required';
        } else {
            $rules['nama'] = 'required';
            $rules['nama_kegiatan'] = 'required';
            $rules['nama_pic'] = 'required';
            $rules['no_telp_pic'] = 'required';
            $rules['asal_persyarikatan'] = 'required';
            $rules['jumlah_peserta'] = 'required|integer|min:1';
            $rules['jumlah_kamar'] = 'required|integer|min:1';
        }

        $r->validate($rules);

        // Store bukti pembayaran
        $buktiPath = $r->file('bukti_pembayaran')->store('public/bukti_pembayaran');

        $data = $r->except('bukti_pembayaran', 'jenis_kamar_pilihan');
        $data['bukti_pembayaran'] = $buktiPath;
        $data['payment_status'] = 'pending';
        $data['jenis_tamu'] = $r->jenis_tamu;
        
        // Store jenis kamar yang dipilih di special_request atau field khusus
        $data['special_request'] = ($r->special_request ?? '') . "\n[Jenis Kamar Pilihan: " . $r->jenis_kamar_pilihan . "]";

        Pengunjung::create($data);

        return redirect()->route('booking.form')->with('success', 'Booking berhasil dikirim! Admin akan verifikasi pembayaran Anda dalam 1x24 jam. Kami akan menghubungi Anda via WhatsApp.');
    }

    // Export bookings / pengunjung as PDF
    public function exportPdf(Request $request)
    {
        $bookings = Pengunjung::latest()->get();
        $meta = [
            'title' => 'Data Booking Penginapan',
            'organization' => 'PESANTREN MAHASISWA KH. MAS MANSUR',
            'location' => env('APP_LOCATION', 'Pesantren Mahasiswa - Lokasi Utama'),
            'date' => now()->format('d M Y'),
        ];

        // If barryvdh/laravel-dompdf is installed, use it
        // If barryvdh/laravel-dompdf is installed, use it
        if (class_exists('\Barryvdh\DomPDF\Facade\Pdf')) {
            $pdfFacade = '\Barryvdh\DomPDF\Facade\Pdf';
            $pdf = call_user_func([$pdfFacade, 'loadView'], 'admin.booking.pdf', compact('bookings','meta'));
            $filename = 'bookings-'.now()->format('Ymd-His').'.pdf';
            return $pdf->download($filename);
        }

        // If dompdf not installed, return HTML view as fallback with instructions
        return response()->view('admin.booking.pdf', compact('bookings','meta'))
            ->header('Content-Type', 'text/html');
    }
}
