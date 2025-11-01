@extends('layouts.app')
@section('title','Review Corporate Booking')

@section('content')
<div style="max-width:980px;margin:24px auto;padding:0 16px">
  <div class="h" style="font-size:28px;font-weight:900;margin-bottom:10px">Corporate Booking Review</div>
  <div style="background:#fff;border:2px solid #a0203c;border-radius:14px;padding:18px">
    @php($d = $data ?? [])
    <p><strong>Nama Lengkap:</strong> {{ $d['full_name'] ?? '-' }}</p>
    <p><strong>Email:</strong> {{ $d['email'] ?? '-' }}</p>
    <p><strong>Telepon:</strong> {{ $d['phone_number'] ?? '-' }}</p>
    <p><strong>Nama Kegiatan:</strong> {{ $d['nama_kegiatan'] ?? '-' }}</p>
    <p><strong>PIC:</strong> {{ $d['nama_pic'] ?? '-' }} ({{ $d['telepon_pic'] ?? '-' }})</p>
    <p><strong>Asal Persyarikatan:</strong> {{ $d['asal_persyarikatan'] ?? '-' }}</p>
    <p><strong>Tanggal Persyarikatan:</strong> {{ $d['tanggal_persyarikatan'] ?? '-' }}</p>
    <p><strong>Jumlah Peserta / Kamar:</strong> {{ $d['jumlah_peserta'] ?? '-' }} / {{ $d['jumlah_kasur'] ?? '-' }}</p>
    <p><strong>Room Type:</strong> {{ $d['room_type'] ?? '-' }}</p>
    <p><strong>Check-in — Check-out:</strong> {{ $d['check_in'] ?? '-' }} → {{ $d['check_out'] ?? '-' }}</p>
    <p><strong>Special Request:</strong> {{ $d['special_request'] ?? '-' }}</p>
    @if(!empty($d['room_image']))
      <img src="{{ asset('images/'.$d['room_image']) }}" alt="Room" style="width:100%;max-width:460px;border-radius:10px;border:2px solid #a0203c;margin-top:10px">
    @endif
  </div>
</div>
@endsection
