@extends('layout')
@section('content')
<div class="container mt-5">
  <h3>Data Pengunjung Penginapan</h3>
  <table class="table table-bordered mt-3">
    <thead>
      <tr><th>No</th><th>Nama</th><th>Jenis</th><th>Check-in</th><th>Check-out</th><th>Kamar</th><th>Aksi</th></tr>
    </thead>
    <tbody>
      @foreach($pengunjungs as $i => $p)
      <tr>
        <td>{{ $i+1 }}</td>
        <td>{{ $p->nama }}</td>
        <td>{{ $p->jenis_tamu }}</td>
        <td>{{ $p->check_in }}</td>
        <td>{{ $p->check_out }}</td>
        <td>{{ $p->nomor_kamar }}</td>
        <td>
          <form action="{{ route('pengunjung.destroy', $p->id) }}" method="POST">@csrf @method('DELETE')
            <button class="btn btn-danger btn-sm">Hapus</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
