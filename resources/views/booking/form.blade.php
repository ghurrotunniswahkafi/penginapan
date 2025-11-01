@extends('layouts.app')

@section('title','PESMA Booking Form')

@section('content')
<style>
/* —— Color tokens ————————————————————— */
:root{
  --bg:#f1cfc4;           /* soft pink header */
  --line:#a0203c;         /* maroon line/border */
  --text:#1b1b1b;
  --muted:#7c7c7c;
  --card:#ffffff;
  --pill:#e8aab7;
  --shadow:0 8px 24px rgba(0,0,0,.06);
}
*{box-sizing:border-box}
.container{max-width:1180px;margin:24px auto;padding:0 16px}
.header{
  background:var(--bg);
  border-radius:14px;
  padding:18px 24px;
  display:flex;align-items:center;justify-content:space-between
}
.h-title{font-size:40px;font-weight:800;color:#1f1f1f;letter-spacing:.5px}

/* —— Progress (garis + titik) ————————————————— */
.progress-rail{
  margin:22px 0 16px;background:#fff;border:2px solid var(--line);
  border-radius:12px;padding:12px 16px;display:flex;align-items:center;gap:28px
}
.progress-rail .s{display:flex;align-items:center;gap:10px;flex:1;min-width:0}
.progress-rail .dot{
  width:16px;height:16px;border-radius:50%;border:3px solid var(--line);background:#fff;flex:0 0 auto
}
.progress-rail .lbl{font-weight:800;color:#111;white-space:nowrap}
.progress-rail .rail{height:8px;flex:1;border-radius:8px;background:#d7a1ab}
.progress-rail .filled .dot{background:var(--line)}
.progress-rail .filled .rail{background:var(--line)}

.card{
  background:var(--card);border:2px solid var(--line);border-radius:16px;padding:18px;
  box-shadow:var(--shadow)
}
.grid{display:grid;grid-template-columns:1.3fr .9fr;gap:22px}
label{font-weight:800;margin-bottom:6px;color:#222;display:block}
.input, select{
  width:100%;padding:14px 12px;border:3px solid var(--line);border-radius:10px;
  outline:none;font-size:16px;background:#fff
}
.row{display:grid;grid-template-columns:1fr 1fr;gap:18px}
.err{color:#a0203c;font-size:13px;margin-top:6px}
.flash{margin:12px 0;padding:12px 14px;border-radius:10px}
.flash-success{background:#e8fff1;border:1px solid #19a05b}
.flash-error{background:#ffe9ee;border:1px solid #a0203c}
.btns{display:flex;gap:18px;margin-top:18px}
.btn-primary{
  background:var(--line);color:#fff;border:none;border-radius:10px;
  padding:12px 22px;font-weight:700;cursor:pointer
}
.btn-ghost{
  background:#fff;border:2px solid var(--line);color:var(--line);
  border-radius:10px;padding:10px 18px;font-weight:700;cursor:pointer
}
.side .room-img{width:100%;border-radius:12px;border:2px solid var(--line);object-fit:cover}
.side .type{background:var(--pill);padding:6px 10px;border-radius:10px;font-weight:700}
.side .field{margin-top:10px}
@media (max-width:960px){ .grid{grid-template-columns:1fr} }

/* —— Note box ————————————————————— */
.note{
  background:#bd6e79; color:#fff; padding:16px 18px; border-radius:12px;
  font-weight:600; line-height:1.55; box-shadow:var(--shadow)
}
.note strong{display:block;margin-bottom:6px}
</style>

<div class="container">
  {{-- Header --}}
  <div class="header">
    <div class="h-title">PESMA Booking Form</div>
  </div>

  {{-- Progress: dot + label + garis penuh (dua langkah pertama filled) --}}
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

  {{-- Flash messages --}}
  @if (session('info'))
    <div class="flash flash-success">{{ session('info') }}</div>
  @endif
  @if (session('error'))
    <div class="flash flash-error">{{ session('error') }}</div>
  @endif

  <form class="grid" method="POST" action="{{ route('booking.store') }}">
    @csrf

    {{-- LEFT: Data diri --}}
    <div class="card">
      <div class="row">
        <div>
          <label for="title">Tittle</label>
          <select name="title" id="title">
            <option value="">Mr/Mrs</option>
            <option value="Mr"  {{ old('title')=='Mr'?'selected':'' }}>Mr</option>
            <option value="Mrs" {{ old('title')=='Mrs'?'selected':'' }}>Mrs</option>
          </select>
          @error('title') <div class="err">{{ $message }}</div> @enderror
        </div>

        <div>
          <label for="first_name">First Name</label>
          <input class="input" id="first_name" name="first_name" value="{{ old('first_name') }}">
          @error('first_name') <div class="err">{{ $message }}</div> @enderror
        </div>
      </div>

      <div class="row" style="margin-top:12px">
        <div>
          <label for="last_name">Last Name</label>
          <input class="input" id="last_name" name="last_name" value="{{ old('last_name') }}">
          @error('last_name') <div class="err">{{ $message }}</div> @enderror
        </div>
        <div></div>
      </div>

      <div style="margin-top:12px">
        <label for="email">Email</label>
        <input class="input" id="email" name="email" value="{{ old('email') }}">
        @error('email') <div class="err">{{ $message }}</div> @enderror
      </div>

      <div style="margin-top:12px">
        <label for="phone">Phone Number</label>
        <input class="input" id="phone" name="phone" value="{{ old('phone') }}">
        @error('phone') <div class="err">{{ $message }}</div> @enderror
      </div>

      {{-- NOTE BOX (tambahan) --}}
      <div class="note" style="margin-top:16px">
        <strong>Catatan:</strong>
        Permintaan khusus (seperti tambahan breakfast, tambahan fasilitas, early check-in,
        atau late check-out) dapat disampaikan langsung kepada pihak resepsionis pada saat
        registrasi, dan akan dipenuhi sesuai dengan ketersediaan kamar.
      </div>

      <div class="btns">
        <button class="btn-primary" type="submit">Book now</button>
        <button class="btn-ghost" type="submit" name="cancel" value="1">Cancel</button>
      </div>
    </div>

    {{-- RIGHT: Panel kamar & tanggal --}}
    <div class="card side">
      <img id="roomPreview" class="room-img" src="{{ asset('images/deluxe.jpg') }}" alt="Room">
      <div style="display:flex;gap:10px;align-items:center;margin-top:10px">
        <div style="font-weight:800;font-size:22px">Room Type</div>
        <span class="type" id="typePill">Deluxe Type</span>
      </div>

      <div class="field">
        <select class="input" name="room_type" id="room_type">
          <option value="">-- pilih tipe kamar --</option>
          <option value="Standard Room" {{ old('room_type')=='Standard Room'?'selected':'' }}>Standard Room</option>
          <option value="Deluxe Room"   {{ old('room_type','Deluxe Room')=='Deluxe Room'?'selected':'' }}>Deluxe Room</option>
          <option value="Suite Room"    {{ old('room_type')=='Suite Room'?'selected':'' }}>Suite Room</option>
        </select>
        @error('room_type') <div class="err">{{ $message }}</div> @enderror
      </div>

      <div style="margin-top:16px">
        <div style="font-weight:800;font-size:20px">Check-in date and time</div>
        <div class="row" style="margin-top:8px">
          <input class="input" type="date" id="check_in" name="check_in"
                 value="{{ old('check_in') }}" min="{{ now()->format('Y-m-d') }}" placeholder="mm/dd/yyyy">
          <input class="input" type="time" name="check_in_time" value="{{ old('check_in_time','12:00') }}" step="900">
        </div>
        @error('check_in') <div class="err">{{ $message }}</div> @enderror
      </div>

      <div style="margin-top:16px">
        <div style="font-weight:800;font-size:20px">Check-out date and time</div>
        <div class="row" style="margin-top:8px">
          <input class="input" type="date" id="check_out" name="check_out"
                 value="{{ old('check_out') }}" placeholder="mm/dd/yyyy">
          <input class="input" type="time" name="check_out_time" value="{{ old('check_out_time','12:00') }}" step="900">
        </div>
        @error('check_out') <div class="err">{{ $message }}</div> @enderror
      </div>
    </div>
  </form>
</div>

<script>
const mapImg = {
  'Standard Room': '{{ asset('images/standard.jpg') }}',
  'Deluxe Room':   '{{ asset('images/deluxe.jpg') }}',
  'Suite Room':    '{{ asset('images/suite.jpg') }}',
};
const mapType = {
  'Standard Room': 'Standard Type',
  'Deluxe Room':   'Deluxe Type',
  'Suite Room':    'Suite Type',
};
const sel = document.getElementById('room_type');
const img = document.getElementById('roomPreview');
const pill= document.getElementById('typePill');

function updatePreview(){
  const v = sel.value || 'Deluxe Room';
  img.src = mapImg[v];
  pill.textContent = mapType[v];
}
sel.addEventListener('change', updatePreview);
updatePreview();

/* —— Lock checkout ≥ H+1 dari check-in ————————————————— */
const inDate  = document.getElementById('check_in');
const outDate = document.getElementById('check_out');

const fmt = d => d.toISOString().slice(0,10);
const addDays = (dateStr, days) => {
  const d = new Date(dateStr);
  d.setDate(d.getDate() + days);
  return fmt(d);
};

function syncMinCheckout() {
  if (!inDate.value) return;
  // minimal check-out = H+1
  const minOut = addDays(inDate.value, 1);
  outDate.min = minOut;
  if (outDate.value && outDate.value < minOut) {
    outDate.value = minOut;
  }
}
syncMinCheckout();
inDate.addEventListener('change', syncMinCheckout);
</script>
@endsection
