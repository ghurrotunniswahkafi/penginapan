@extends('layouts.app')
@section('title','PESMA Corporate Booking Form')

@section('content')
<style>
:root{
  --bg:#f1cfc4; --line:#a0203c; --card:#fff; --shadow:0 8px 24px rgba(0,0,0,.06);
  --pill:#e8aab7;
}
*{box-sizing:border-box}
body{background:#fbf7f6}
.container{max-width:1180px;margin:24px auto;padding:0 16px}

/* Header */
.header{
  background:var(--bg); border-radius:14px; padding:18px 24px;
  display:flex; align-items:center; justify-content:space-between
}
.h-title{font-size:40px; font-weight:800}
.btn-pay{background:var(--line); color:#fff; border:none; border-radius:12px; padding:12px 20px; font-weight:700}

/* Progress: garis + titik */
.progress-rail{
  margin:22px 0 16px; background:#fff; border:2px solid var(--line);
  border-radius:12px; padding:12px 16px; display:flex; align-items:center; gap:28px
}
.progress-rail .s{display:flex; align-items:center; gap:10px; flex:1; min-width:0}
.progress-rail .dot{width:16px; height:16px; border-radius:50%; border:3px solid var(--line); background:#fff}
.progress-rail .lbl{font-weight:800; white-space:nowrap}
.progress-rail .rail{height:8px; flex:1; border-radius:8px; background:#d7a1ab}
.progress-rail .filled .dot{background:var(--line)}
.progress-rail .filled .rail{background:var(--line)}

.grid{display:grid; grid-template-columns:1.2fr .8fr; gap:22px}
.card{background:var(--card); border:2px solid var(--line); border-radius:16px; padding:18px; box-shadow:var(--shadow)}
label{font-weight:800; display:block; margin-bottom:6px}
.input, select{width:100%; padding:14px 12px; border:3px solid var(--line); border-radius:10px; font-size:16px; background:#fff}
.row-1{display:grid; grid-template-columns:1fr; gap:14px}
.row-2{display:grid; grid-template-columns:1fr 1fr; gap:14px}

.side .room-img{width:100%; border-radius:12px; border:2px solid var(--line); object-fit:cover}
.pill{background:var(--pill); color:#fff; font-weight:800; border-radius:10px; padding:6px 10px}

.note{background:#bd6e79; color:#fff; padding:16px 18px; border-radius:12px; font-weight:600; line-height:1.55; box-shadow:var(--shadow)}
.bullets{margin:10px 0 0 0; padding-left:20px}
.btns{display:flex; gap:16px; justify-content:flex-end; margin-top:16px}
.btn-primary{background:var(--line); color:#fff; border:none; border-radius:10px; padding:10px 18px; font-weight:800}
.btn-ghost{background:#fff; border:2px solid var(--line); color:var(--line); border-radius:10px; padding:10px 18px; font-weight:800}
.err{color:#a0203c; font-size:13px; margin-top:6px}
@media (max-width:960px){ .grid{grid-template-columns:1fr} .btns{justify-content:flex-start} }
</style>

<div class="container">
  <div class="header">
    <div class="h-title">PESMA Corporate Booking Form</div>
    <button type="button" class="btn-pay">PAYMENTS DETAILS</button>
  </div>

  {{-- Progress: step 1 & 2 filled --}}
  <div class="progress-rail">
    <div class="s filled">
      <span class="dot"></span><span class="lbl">Isi Data</span><span class="rail"></span>
    </div>
    <div class="s filled">
      <span class="dot"></span><span class="lbl">Booking</span><span class="rail"></span>
    </div>
    <div class="s">
      <span class="dot"></span><span class="lbl">Payment</span><span class="rail"></span>
    </div>
  </div>

  @if (session('info'))  <div class="card" style="border-color:#19a05b">{{ session('info') }}</div> @endif
  @if (session('error')) <div class="card" style="border-color:#a0203c">{{ session('error') }}</div> @endif

  <form class="grid" method="POST" action="{{ route('corporate.booking.store') }}" id="corpForm">
    @csrf

    {{-- LEFT FORM --}}
    <div class="card">
      <div class="row-1">
        <div>
          <label for="full_name">Full Name</label>
          <input class="input" id="full_name" name="full_name" value="{{ old('full_name') }}">
          @error('full_name') <div class="err">{{ $message }}</div> @enderror
        </div>
        <div>
          <label for="email">Email</label>
          <input class="input" id="email" name="email" value="{{ old('email') }}">
          @error('email') <div class="err">{{ $message }}</div> @enderror
        </div>
        <div>
          <label for="phone_number">Phone Number</label>
          <input class="input" id="phone_number" name="phone_number" value="{{ old('phone_number') }}">
          @error('phone_number') <div class="err">{{ $message }}</div> @enderror
        </div>
        <div>
          <label for="nama_kegiatan">Nama Kegiatan</label>
          <input class="input" id="nama_kegiatan" name="nama_kegiatan" value="{{ old('nama_kegiatan') }}">
          @error('nama_kegiatan') <div class="err">{{ $message }}</div> @enderror
        </div>
        <div>
          <label for="nama_pic">Nama PIC</label>
          <input class="input" id="nama_pic" name="nama_pic" value="{{ old('nama_pic') }}">
          @error('nama_pic') <div class="err">{{ $message }}</div> @enderror
        </div>
        <div>
          <label for="telepon_pic">No. Telepon PIC</label>
          <input class="input" id="telepon_pic" name="telepon_pic" value="{{ old('telepon_pic') }}">
          @error('telepon_pic') <div class="err">{{ $message }}</div> @enderror
        </div>
        <div>
          <label for="asal_persyarikatan">Asal Persyarikatan</label>
          <input class="input" id="asal_persyarikatan" name="asal_persyarikatan" value="{{ old('asal_persyarikatan') }}">
          @error('asal_persyarikatan') <div class="err">{{ $message }}</div> @enderror
        </div>
        <div>
          <label for="tanggal_persyarikatan">Tanggal Persyarikatan</label>
          <input class="input" type="date" id="tanggal_persyarikatan" name="tanggal_persyarikatan" value="{{ old('tanggal_persyarikatan') }}">
          @error('tanggal_persyarikatan') <div class="err">{{ $message }}</div> @enderror
        </div>

        <div class="row-2">
          <div>
            <label for="jumlah_peserta">Jumlah Peserta</label>
            <input class="input" id="jumlah_peserta" name="jumlah_peserta" type="number" min="1" value="{{ old('jumlah_peserta') }}">
            @error('jumlah_peserta') <div class="err">{{ $message }}</div> @enderror
          </div>
          <div>
            <label for="jumlah_kasur">Jumlah Kamar</label>
            <input class="input" id="jumlah_kasur" name="jumlah_kasur" type="number" min="1" value="{{ old('jumlah_kasur') }}">
            @error('jumlah_kasur') <div class="err">{{ $message }}</div> @enderror
          </div>
        </div>
      </div>
    </div>

    {{-- RIGHT PANEL --}}
    <div class="card side">
      <img class="room-img" src="{{ asset('images/deluxe.jpg') }}" alt="Room">
      <div style="display:flex;align-items:center;gap:10px;margin-top:10px">
        <div style="font-weight:800">Room Type</div>
        <span class="pill">Deluxe Type</span>
      </div>
      {{-- hidden agar sesuai validasi controller --}}
      <input type="hidden" name="room_type" value="Deluxe Room">

      <div style="margin-top:14px">
        <div style="font-weight:800;font-size:18px">Check-in date and time</div>
        <div class="row-2">
          <input class="input" type="date" id="check_in" name="check_in" value="{{ old('check_in') }}" min="{{ now()->format('Y-m-d') }}">
          <input class="input" type="time" id="check_in_time" name="check_in_time" value="{{ old('check_in_time','14:00') }}" step="900">
        </div>
        @error('check_in') <div class="err">{{ $message }}</div> @enderror
      </div>

      <div style="margin-top:14px">
        <div style="font-weight:800;font-size:18px">Check-out date and time</div>
        <div class="row-2">
          <input class="input" type="date" id="check_out" name="check_out" value="{{ old('check_out') }}">
          <input class="input" type="time" id="check_out_time" name="check_out_time" value="{{ old('check_out_time','12:00') }}" step="900">
        </div>
        @error('check_out') <div class="err">{{ $message }}</div> @enderror
      </div>

      <div class="note" style="margin-top:18px">
        <div style="font-size:20px;font-weight:900;margin-bottom:6px">Special Request</div>
        <ul class="bullets">
          <li><label><input type="checkbox" class="sr" value="Konsumsi Snack"> Konsumsi Snack</label></li>
          <li><label><input type="checkbox" class="sr" value="Konsumsi Makanan"> Konsumsi Makanan</label></li>
        </ul>
        <input type="hidden" name="special_request" id="special_request" value="{{ old('special_request') }}">
      </div>
    </div>
  </form>

  <div class="btns">
    <button form="corpForm" class="btn-primary" type="submit">Book now</button>
    <button form="corpForm" class="btn-ghost" type="submit" name="cancel" value="1">Cancel</button>
  </div>
</div>

<script>
// —— Lock checkout ≥ H+1 dari check-in
const inDate  = document.getElementById('check_in');
const outDate = document.getElementById('check_out');
const fmt = d => d.toISOString().slice(0,10);
const addDays = (s, n) => { const d = new Date(s); d.setDate(d.getDate()+n); return fmt(d); };

function syncMinOut(){
  if(!inDate.value) return;
  const minOut = addDays(inDate.value, 1);
  outDate.min = minOut;
  if(outDate.value && outDate.value < minOut){ outDate.value = minOut; }
}
syncMinOut(); inDate.addEventListener('change', syncMinOut);

// —— Gabungkan checkbox Special Request → hidden input
const boxes = document.querySelectorAll('.sr');
const srHidden = document.getElementById('special_request');
function syncSR(){
  const vals = Array.from(boxes).filter(b=>b.checked).map(b=>b.value);
  srHidden.value = vals.join(', ');
}
boxes.forEach(b=> b.addEventListener('change', syncSR));
syncSR();
</script>
@endsection
