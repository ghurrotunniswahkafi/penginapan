<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\Booking;
use Carbon\Carbon; // ➜ pastikan ini ada

class BookingController extends Controller
{
    public function index()
    {
        return view('booking.form');
    }

    public function store(Request $request)
    {
        if ($request->has('cancel')) {
            return redirect()
                ->route('booking.form')
                ->with('info', 'Pemesanan telah dibatalkan.');
        }

        // (VALIDASI ANDA TETAP SAMA)
        $messages = [
            'title.required'          => 'Silakan pilih title Anda.',
            'first_name.required'     => 'Nama depan wajib diisi.',
            'last_name.required'      => 'Nama belakang wajib diisi.',
            'email.required'          => 'Email wajib diisi.',
            'email.email'             => 'Format email tidak valid.',
            'phone.required'          => 'Nomor telepon wajib diisi.',
            'phone.max'               => 'Nomor telepon tidak boleh lebih dari 15 angka.',
            'room_type.required'      => 'Silakan pilih tipe kamar.',
            'check_in.required'       => 'Tanggal check-in wajib diisi.',
            'check_out.required'      => 'Tanggal check-out wajib diisi.',
            'check_in.after_or_equal' => 'Tanggal check-in tidak boleh sebelum hari ini.',
            'check_out.after_or_equal'=> 'Tanggal check-out harus setelah atau sama dengan tanggal check-in.',
        ];

        $validated = $request->validate([
            'title'      => 'required|string|max:4',
            'first_name' => 'required|string|max:25',
            'last_name'  => 'required|string|max:25',
            'email'      => 'required|email|max:25',
            'phone'      => 'required|string|max:15',
            'room_type'  => 'required|string|max:25',
            'check_in'   => 'required|date|after_or_equal:today',
            'check_out'  => 'required|date|after_or_equal:check_in',
            // opsional jika Anda pakai jam di form biasa:
            'check_in_time'  => 'nullable|date_format:H:i',
            'check_out_time' => 'nullable|date_format:H:i',
        ], $messages);

        // gabungkan nama penuh
        $validated['full_name'] = trim($validated['title'].' '.$validated['first_name'].' '.$validated['last_name']);

        // cek duplikat
        $duplicate = Booking::where('full_name', $validated['full_name'])
            ->where('check_in', $validated['check_in'])
            ->exists();

        if ($duplicate) {
            return back()->withInput()->with('error', 'Pemesanan dengan nama dan tanggal check-in ini sudah ada.');
        }

        // mapping gambar kamar
        $roomImages = [
            'Standard Room' => 'standard.jpg',
            'Deluxe Room'   => 'deluxe.jpg',
            'Suite Room'    => 'suite.jpg',
        ];
        $validated['room_image'] = $roomImages[$validated['room_type']] ?? null;

        // ➜ SIMPAN DATA KE SESSION (agar Payment Details bisa pakai)
        session(['booking' => $validated]);

        // simpan ke DB
        $payload = Arr::only($validated, [
            'title','first_name','last_name','full_name',
            'email','phone','room_type',
            'check_in','check_out',
            // 'room_image',            // aktifkan jika kolomnya SUDAH ada
            // 'check_in_time','check_out_time', // aktifkan jika kolomnya SUDAH ada
        ]);

Booking::create($payload);

        // ➜ ARAHKAN KE HALAMAN PAYMENT
        return redirect()->route('payment.details');

        // (kalau tetap mau review dulu, pakai ini sebagai alternatif)
        // return view('booking.review', ['data' => $validated]);
    }

    // ➜ METHOD BARU UNTUK HALAMAN PAYMENT
    public function payment()
    {
        $data = session('booking');
        if (!$data) {
            return redirect()->route('booking.form')
                ->with('error', 'Data booking tidak ditemukan. Silakan isi form terlebih dahulu.');
        }

        // hitung malam & contoh biaya
        $in  = Carbon::parse(($data['check_in']).' '.($data['check_in_time'] ?? '16:00'));
        $out = Carbon::parse(($data['check_out']).' '.($data['check_out_time'] ?? '11:00'));
        $nights = max($in->diffInDays($out), 1);

        $ratePerNight = 555000; // contoh
        $devFee       = 665000; // contoh
        $subtotal     = $nights * $ratePerNight;
        $total        = $subtotal + $devFee;

        return view('payment.details', compact('data','nights','ratePerNight','subtotal','devFee','total'));
    }

    public function review()
    {
        return view('booking.review');
    }
}
