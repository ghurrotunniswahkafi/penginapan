@extends('layout')
@section('content')
<div class="container text-center mt-5">
  <h2>Dashboard Admin</h2>
  <div class="row mt-4">
    <div class="col-md-4"><div class="card p-3">Kamar Tersedia: {{ $totalKamar }}</div></div>
    <div class="col-md-4"><div class="card p-3">Kamar Kosong: {{ $kamarKosong }}</div></div>
    <div class="col-md-4"><div class="card p-3">Jumlah Pengunjung: {{ $jumlahPengunjung }}</div></div>
  </div>
</div>
@endsection
