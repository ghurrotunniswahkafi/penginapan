@extends('layout')

@section('content')
<style>
  .stat-card{
    background:rgba(179,18,59,.35);
    color:#fff;
    border-radius:28px;
    padding:32px 20px;
    text-align:center;
    box-shadow:0 12px 30px rgba(179,18,59,.15);
    backdrop-filter:blur(2px);
  }
  .stat-icon{
    width:72px;
    height:72px;
    border-radius:20px;
    background:rgba(255,255,255,.25);
    margin:0 auto 14px;
    display:grid;
    place-items:center;
  }
  .stat-value{
    font-size:32px;
    font-weight:800;
    letter-spacing:.3px;
    margin-bottom:6px;
  }
  .stat-label{
    opacity:.95;
    font-weight:500;
    font-size:15px;
  }
</style>

<div class="text-center pt-6">
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-5xl mx-auto">
    
    <!-- Kamar Tersedia (Available) -->
    <div class="stat-card">
      <div class="stat-icon">
        <img src="{{ asset('img/chart.png') }}" alt="Chart" class="w-9 h-9">
      </div>
      <div class="stat-value">{{ $totalKamar > 0 ? round(($kamarKosong / max($totalKamar,1)) * 100) : 0 }}%</div>
      <div class="stat-label">Kamar Tersedia</div>
    </div>

    <!-- Kamar Kosong (Occupied) -->
    <div class="stat-card" style="background:rgba(179,18,59,.45)">
      <div class="stat-icon">
        <img src="{{ asset('img/chart.png') }}" alt="Chart" class="w-9 h-9">
      </div>
      <div class="stat-value">{{ $totalKamar > 0 ? round((($totalKamar - $kamarKosong) / max($totalKamar,1)) * 100) : 0 }}%</div>
      <div class="stat-label">Kamar Kosong</div>
    </div>

    <!-- Jumlah Pengunjung -->
    <div class="stat-card" style="background:rgba(179,18,59,.5)">
      <div class="stat-icon">
        <img src="{{ asset('img/chart.png') }}" alt="Chart" class="w-9 h-9">
      </div>
      <div class="stat-value">{{ $jumlahPengunjung }}</div>
      <div class="stat-label">Jumlah Pengunjung</div>
    </div>
    
  </div>
</div>
@endsection
