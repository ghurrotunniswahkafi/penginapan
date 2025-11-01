<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CorporateBooking;
use Carbon\Carbon;

class CorporateBookingController extends Controller
{
    public function index()
    {
        return view('corporate.corporateform');
    }

    public function store(Request $request)
    {
        if ($request->has('cancel')) {
            return redirect()
                ->route('corporate.booking.form')
                ->with('info', 'Pemesanan corporate telah dibatalkan.');
        }

        // Gabungkan checkbox special_request[] -> string
        $request->merge([
            'special_request' => implode(', ', $request->input('special_request', [])),
        ]);

        $messages = [
            'full_name.required'            => 'Nama lengkap wajib diisi.',
            'email.required'                => 'Email wajib diisi.',
            'email.email'                   => 'Format email tidak valid.',
            'phone_number.required'         => 'Nomor telepon wajib diisi.',
            'phone_number.max'              => 'Nomor telepon tidak boleh lebih dari 15 angka.',
            'nama_kegiatan.required'        => 'Nama kegiatan wajib diisi.',
            'nama_pic.required'             => 'Nama PIC wajib diisi.',
            'telepon_pic.required'          => 'Nomor telepon PIC wajib diisi.',
            'telepon_pic.max'               => 'Nomor telepon tidak boleh lebih dari 15 angka.',
            'asal_persyarikatan.required'   => 'Asal persyarikatan wajib diisi.',
            'tanggal_persyarikatan.required'=> 'Tanggal persyarikatan wajib diisi.',
            'jumlah_peserta.required'       => 'Jumlah peserta wajib diisi.',
            'jumlah_peserta.integer'        => 'Jumlah peserta harus berupa angka.',
            'jumlah_kasur.required'         => 'Jumlah kamar/kasur wajib diisi.',
            'jumlah_kasur.integer'          => 'Jumlah kamar/kasur harus berupa angka.',
            'room_type.required'            => 'Silakan pilih tipe kamar.',
            'check_in.required'             => 'Tanggal check-in wajib diisi.',
            'check_out.required'            => 'Tanggal check-out wajib diisi.',
            'check_in.after_or_equal'       => 'Tanggal check-in tidak boleh sebelum hari ini.',
            'check_out.after'               => 'Tanggal check-out harus setelah tanggal check-in (minimal H+1).',
            'check_in_time.required'        => 'Jam check-in wajib diisi.',
            'check_out_time.required'       => 'Jam check-out wajib diisi.',
            'check_in_time.date_format'     => 'Format jam check-in HH:MM.',
            'check_out_time.date_format'    => 'Format jam check-out HH:MM.',
        ];

        $validated = $request->validate([
            'full_name'            => 'required|string|max:60',
            'email'                => 'required|email|max:60',
            'phone_number'         => 'required|string|max:15',
            'nama_kegiatan'        => 'required|string|max:80',
            'nama_pic'             => 'required|string|max:60',
            'telepon_pic'          => 'required|string|max:15',
            'asal_persyarikatan'   => 'required|string|max:80',
            'tanggal_persyarikatan'=> 'required|date',
            'jumlah_peserta'       => 'required|integer|min:1',
            'jumlah_kasur'         => 'required|integer|min:1',
            'room_type'            => 'required|string|max:25',
            'check_in'             => 'required|date|after_or_equal:today',
            'check_in_time'        => 'required|date_format:H:i',
            'check_out'            => 'required|date|after:check_in', // minimal H+1 di UI, after di server
            'check_out_time'       => 'required|date_format:H:i',
            'special_request'      => 'nullable|string|max:255',
        ], $messages);

        // Validasi datetime gabungan
        $in  = Carbon::parse($validated['check_in'].' '.$validated['check_in_time']);
        $out = Carbon::parse($validated['check_out'].' '.$validated['check_out_time']);
        if ($out->lte($in)) {
            return back()->withInput()->with('error','Check-out tidak boleh sama/lebih awal dari check-in.');
        }

        // Duplikat: nama kegiatan + tanggal persyarikatan
        $duplicate = CorporateBooking::where('nama_kegiatan', $validated['nama_kegiatan'])
            ->where('tanggal_persyarikatan', $validated['tanggal_persyarikatan'])
            ->exists();
        if ($duplicate) {
            return back()->withInput()->with('error', 'Data kegiatan dengan tanggal persyarikatan ini sudah ada.');
        }

        // Mapping gambar kamar
        $roomImages = [
            'Standard Room' => 'standard.jpg',
            'Deluxe Room'   => 'deluxe.jpg',
            'Suite Room'    => 'suite.jpg',
        ];
        $validated['room_image'] = $roomImages[$validated['room_type']] ?? 'deluxe.jpg';

        CorporateBooking::create($validated);

        return view('corporate.corporatereview', ['data' => $validated]);
    }

    public function review()
    {
        return view('corporate.corporatereview');
    }
}
