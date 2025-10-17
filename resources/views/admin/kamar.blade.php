@extends('layout')
@section('content')
<div class="container mt-5">
  <h3>Data Kamar Penginapan</h3>
  <table class="table table-bordered mt-3">
    <thead>
      <tr><th>No</th><th>Nomor</th><th>Jenis</th><th>Gedung</th><th>Harga</th><th>Status</th><th>Aksi</th></tr>
    </thead>
    <tbody>
      @foreach($kamars as $i => $k)
      <tr>
        <td>{{ $i+1 }}</td>
        <td>{{ $k->nomor_kamar }}</td>
        <td>{{ $k->jenis_kamar }}</td>
        <td>{{ $k->gedung }}</td>
        <td>{{ $k->harga }}</td>
        <td>{{ $k->status }}</td>
        <td>
          <form action="{{ route('kamar.destroy', $k->id) }}" method="POST">@csrf @method('DELETE')
            <button class="btn btn-danger btn-sm">Hapus</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
