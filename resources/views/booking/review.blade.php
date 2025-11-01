@extends('layouts.app')
@section('title','Review Booking')

@section('content')
<style>
.wrap{max-width:900px;margin:26px auto;padding:0 16px}
.card{background:#fff;border:2px solid #a0203c;border-radius:14px;padding:18px}
.row{display:grid;grid-template-columns:1fr 1fr;gap:16px}
.h{font-size:28px;font-weight:800;margin-bottom:12px}
.label{font-weight:800;color:#333}
.v{margin:4px 0 14px}
.btn{display:inline-block;margin-top:10px;background:#a0203c;color:#fff;
     border:none;border-radius:10px;padding:10px 18px;font-weight:700;text-decoration:none}
</style>

<div class="wrap">
  <div class="h">Booking Review</div>
  <div class="card">
    @php($d = $data ?? [])
    <div class="row">
      <div>
        <div class="label">Nama Tamu</div>
        <div class="v">{{ $d['full_name'] ?? '-' }}</div>

        <div class="label">Email</div>
        <div class="v">{{ $d['email'] ?? '-' }}</div>

        <div class="label">Telepon</div>
        <div class="v">{{ $d['phone'] ?? '-' }}</div>
      </div>
      <div>
        <div class="label">Tipe Kamar</div>
        <div class="v">{{ $d['room_type'] ?? '-' }}</div>

        <div class="label">Tanggal</div>
        <div class="v">
          Check-in: {{ \Carbon\Carbon::parse($d['check_in'] ?? now())->format('d M Y') }} —
          Check-out: {{ \Carbon\Carbon::parse($d['check_out'] ?? now())->format('d M Y') }}
        </div>

        @if(!empty($d['room_image']))
          <img src="{{ asset('images/'.$d['room_image']) }}" alt="Room" style="width:100%;border-radius:10px;border:2px solid #a0203c">
        @endif
      </div>
    </div>

    <a class="btn" href="{{ route('booking.form') }}">Buat Booking Baru</a>
  </div>
</div>
@endsection
