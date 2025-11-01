@extends('layout')
@section('content')
<style>
  .section-header{background:var(--brand);color:#fff;border-radius:18px;padding:18px 22px;display:flex;align-items:center;justify-content:space-between;margin-bottom:14px}
  .pill-btn{background:#fff;color:var(--brand);border:0;border-radius:999px;padding:8px 16px;font-weight:700;text-decoration:none}
  .pill-btn:hover{filter:brightness(95%)}
  .table-shell{background:rgba(179,18,59,.08); border-radius:18px; padding:18px}
  .data-table{width:100%;border-collapse:collapse}
  .data-table thead th{background:#f5d7de;padding:12px;text-align:left;color:#7b1a2e;font-weight:600;border-bottom:2px solid #e8c5d0}
  .data-table tbody td{background:#fff;padding:12px;border-bottom:1px solid #f0e1e5}
  .data-table tbody tr:last-child td{border-bottom:0}
  .btn-delete{background:#dc3545;color:#fff;border:0;padding:6px 12px;border-radius:6px;font-size:13px;cursor:pointer}
  .btn-delete:hover{background:#c82333}
</style>

{{-- <div class="section-header">
  <a href="{{ route('admin.dashboard') }}" class="pill-btn">Kembali</a>
</div> --}}

<div class="table-shell">
  <div style="font-weight:600;margin-bottom:12px;color:#7b1a2e">DATA PENGUNJUNG PENGINAPAN</div>
  <div style="overflow-x:auto">
    <table class="data-table">
      <thead>
        <tr>
          <th>Nama</th>
          <th>Identitas</th>
          <th>No Identitas</th>
          <th>Jenis Tamu</th>
          <th>Check-in</th>
          <th>Check-out</th>
          <th>Nomor Kamar</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($pengunjungs as $p)
        <tr>
          <td>{{ $p->nama }}</td>
          <td>KTP</td>
          <td>{{ $p->no_identitas }}</td>
          <td>{{ $p->jenis_tamu }}</td>
          <td>{{ $p->check_in }}</td>
          <td>{{ $p->check_out }}</td>
          <td>{{ $p->nomor_kamar }}</td>
          <td>
            <form action="{{ route('pengunjung.destroy', $p->id) }}" method="GET" onsubmit="return confirm('Hapus pengunjung ini?')" style="display:inline">
              <button class="btn-delete">Hapus</button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="8" style="text-align:center;color:#999;padding:24px">Belum ada data.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
