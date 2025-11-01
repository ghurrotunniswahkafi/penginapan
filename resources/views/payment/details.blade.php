@extends('layouts.app')
@section('title','PAYMENTS DETAILS')

@section('content')
<style>
:root{
  --bg:#f1cfc4; --line:#a0203c; --card:#fff; --muted:#7a7a7a; --shadow:0 8px 24px rgba(0,0,0,.06);
}
*{box-sizing:border-box} body{background:#fbf7f6}
.container{max-width:1180px;margin:24px auto;padding:0 16px}
.h-title{font-size:48px;font-weight:900;text-align:center;letter-spacing:1px;margin-bottom:12px;color:#1f1f1f}

/* Progress: garis + titik */
.progress-rail{
  margin:0 0 18px; background:#fff; border:2px solid var(--line);
  border-radius:12px; padding:12px 16px; display:flex; align-items:center; gap:28px
}
.progress-rail .s{display:flex; align-items:center; gap:10px; flex:1; min-width:0}
.progress-rail .dot{width:16px; height:16px; border-radius:50%; border:3px solid var(--line); background:var(--line)}
.progress-rail .lbl{font-weight:800; white-space:nowrap}
.progress-rail .rail{height:8px; flex:1; border-radius:8px; background:var(--line)}

.banner{background:#e8c1b8;border-radius:16px;padding:16px 18px;display:flex;gap:14px;align-items:center;margin-bottom:14px}
.banner .icon{width:48px;height:48px;border-radius:12px;background:#a0203c;display:grid;place-items:center;color:#fff;font-size:26px}
.grid{display:grid;grid-template-columns:1.2fr .8fr;gap:22px;margin-top:6px}
.card{background:var(--card);border:2px solid var(--line);border-radius:16px;padding:18px;box-shadow:var(--shadow)}
.split{display:grid;grid-template-columns:1fr 1fr;gap:18px}
.kv{display:flex;flex-direction:column;gap:6px}
.kv .k{font-weight:900;color:#222}
.kv .v{color:#111}
.hr{height:2px;background:#d9a8b2;margin:14px 0;border-radius:4px}
.paylogos{display:flex;gap:18px;flex-wrap:wrap}
.paylogos img{width:72px;height:48px;object-fit:contain;border-radius:12px;background:#fff;box-shadow:var(--shadow);padding:8px;border:1px solid #efefef}
.qr{width:140px;height:140px;border-radius:10px;background:#fff;border:2px solid #eee;display:grid;place-items:center}
.box{border:2px solid var(--line);border-radius:16px;padding:16px}
.summary{display:grid;gap:12px}
.sumrow{display:flex;justify-content:space-between;gap:8px}
.sumrow .label{font-weight:800}
.sumrow.total{font-weight:900}
.btns{display:flex;gap:14px;justify-content:flex-end;margin-top:16px}
.btn-primary{background:var(--line);color:#fff;border:none;border-radius:12px;padding:12px 18px;font-weight:800;cursor:pointer}
.btn-ghost{background:#fff;border:2px solid var(--line);color:var(--line);border-radius:12px;padding:12px 18px;font-weight:800;cursor:pointer;text-decoration:none;display:inline-block}
.small{color:var(--muted);font-size:13px}
@media (max-width:960px){ .grid{grid-template-columns:1fr} .btns{justify-content:flex-start} }

/* Floating Dashboard Button */
.fab-dash{
  position:fixed; right:24px; bottom:24px; z-index:60;
  background:var(--line); color:#fff; border:none; border-radius:999px;
  padding:12px 16px; display:flex; align-items:center; gap:8px;
  font-weight:800; text-decoration:none; box-shadow:0 10px 24px rgba(0,0,0,.12);
}
.fab-dash:hover{ transform:translateY(-1px); box-shadow:0 12px 28px rgba(0,0,0,.18); }
.fab-dash svg{ width:18px; height:18px; display:block }
</style>

@php
  $d = $data ?? [];
  $fmtID = fn($n) => number_format((float)$n,0,',','.');
  $checkIn  = \Carbon\Carbon::parse(($d['check_in'] ?? now()).' '.($d['check_in_time'] ?? '16:00'))->locale('id');
  $checkOut = \Carbon\Carbon::parse(($d['check_out'] ?? now()->addDay()).' '.($d['check_out_time'] ?? '11:00'))->locale('id');

  $hariIn  = $checkIn->translatedFormat('l, j F Y');
  $jamIn   = $checkIn->translatedFormat('H.i').' WIB';
  $hariOut = $checkOut->translatedFormat('l, j F Y');
  $jamOut  = $checkOut->translatedFormat('H.i').' WIB';

  $nights   = $nights ?? max($checkIn->diffInDays($checkOut),1);
  $fullName = $d['full_name'] ?? trim(($d['title'] ?? '').' '.($d['first_name'] ?? '').' '.($d['last_name'] ?? ''));
  $phone    = $d['phone'] ?? $d['phone_number'] ?? '-';
  $room     = $d['room_type'] ?? 'Deluxe Room';

  $ratePerNight = $ratePerNight ?? 555000;
  $subtotal     = $subtotal     ?? ($nights * $ratePerNight);
  $devFee       = $devFee       ?? 665000;
  $total        = $total        ?? ($subtotal + $devFee);
@endphp

<div class="container">
  <div class="h-title">PAYMENTS DETAILS</div>

  {{-- Progress (semua langkah terisi hingga Payment) --}}
  <div class="progress-rail">
    <div class="s"><span class="dot"></span><span class="lbl">Isi Data</span><span class="rail"></span></div>
    <div class="s"><span class="dot"></span><span class="lbl">Booking</span><span class="rail"></span></div>
    <div class="s"><span class="dot"></span><span class="lbl">Payment</span><span class="rail"></span></div>
  </div>

  <div class="banner">
    <div class="icon">✓</div>
    <div>
      <div style="font-weight:900;font-size:20px">Pesanan Anda Terkonfirmasi</div>
      <div class="small">Segera lakukan pembayaran sebelum 24 jam, menggunakan metode pembayaran yang tersedia.</div>
    </div>
  </div>

  <div class="grid">
    {{-- LEFT: Booking details & methods --}}
    <div class="card">
      <div style="font-size:24px;font-weight:900;margin-bottom:6px">Booking Details</div>

      <div class="split">
        <div class="kv"><div class="k">NAMA</div><div class="v">{{ $fullName ?: '-' }}</div></div>
        <div class="kv"><div class="k">CHECK-IN</div><div class="v">{{ $hariIn }}<br><b>{{ $jamIn }}</b></div></div>

        <div class="kv"><div class="k">NO TELEPON</div><div class="v">{{ $phone }}</div></div>
        <div class="kv"><div class="k">CHECK-OUT</div><div class="v">{{ $hariOut }}<br><b>{{ $jamOut }}</b></div></div>

        <div class="kv"><div class="k">RESERVATION</div><div class="v">{{ $nights }} hari</div></div>
        <div class="kv"><div class="k">EMAIL</div><div class="v">{{ $d['email'] ?? '-' }}</div></div>
      </div>

      <div class="hr"></div>

      <div style="font-size:22px;font-weight:900;margin-bottom:10px">Method Payments</div>
      <div class="paylogos">
        <img src="{{ asset('images/payment/BSI.png') }}"   alt="BSI">
        <img src="{{ asset('images/payment/BRIMO.png') }}" alt="BRI Mobile/BRImo">
        <img src="{{ asset('images/payment/LIVIN.png') }}" alt="Livin">
        <img src="{{ asset('images/payment/BCA.png') }}"   alt="BCA">
        <img src="{{ asset('images/payment/BNI.png') }}"   alt="BNI">
        <img src="{{ asset('images/payment/CIMB.png') }}"  alt="CIMB">
        <img src="{{ asset('images/payment/BISA.png') }}"  alt="BI-SAtu / BISA">
      </div>

      <div style="display:flex;gap:22px;align-items:center;margin-top:18px">
        <div class="qr">
          <img src="{{ asset('images/payment/QRCODE.png') }}" alt="QR Code" style="width:120px;height:120px;object-fit:contain">
        </div>
        <div style="font-weight:800;color:#a0203c">More details for Payment</div>
      </div>
    </div>

    {{-- RIGHT: Summary --}}
    <div class="box">
      <div style="font-size:24px;font-weight:900;text-align:center;margin-bottom:12px">Booking Summary</div>

      <div class="card" style="padding:14px;border-radius:14px">
        <div class="split" style="grid-template-columns:1fr 1fr">
          <div class="kv"><div class="k">CHECK-IN</div><div class="v">{{ $hariIn }}<br><b>{{ $jamIn }}</b></div></div>
          <div class="kv"><div class="k">CHECK-OUT</div><div class="v">{{ $hariOut }}<br><b>{{ $jamOut }}</b></div></div>
          <div class="kv"><div class="k">ROOM SELECTED</div><div class="v">{{ $room }}</div></div>
          <div class="kv"><div class="k">RESERVATION</div><div class="v">{{ $nights }} hari</div></div>
        </div>
      </div>

      <div style="font-size:22px;font-weight:900;margin:14px 0 8px">Price Summary</div>
      <div class="summary">
        <div class="sumrow"><div class="label">Hunian</div><div>{{ $fmtID($subtotal) }}</div></div>
        <div class="sumrow"><div class="label">Biaya Pengembangan</div><div>{{ $fmtID($devFee) }}</div></div>
        <div class="sumrow total"><div class="label">Total</div><div>{{ $fmtID($total) }}</div></div>
      </div>

      <div class="btns">
        <button class="btn-primary" type="button"
          onclick="alert('Terima kasih. Silakan lanjutkan pembayaran via metode pilihan Anda.')">
          Booking Sekarang
        </button>
        <a href="{{ route('booking.form') }}" class="btn-ghost">Cancel</a>
      </div>
    </div>
  </div>
</div>

{{-- FAB Dashboard (pojok kanan bawah) --}}
<a class="fab-dash"
   href="{{ \Illuminate\Support\Facades\Route::has('dashboard') ? route('dashboard') : url('/') }}"
   title="Kembali ke Dashboard">
  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
       stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
    <path d="M3 11l9-8 9 8"></path>
    <path d="M9 22V12h6v10"></path>
  </svg>
  <span>Dashboard</span>
</a>
@endsection
