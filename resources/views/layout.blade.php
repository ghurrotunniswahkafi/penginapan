<!DOCTYPE html>
<html>
<head>
  <title>Admin Penginapan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-danger">
    <div class="container-fluid">
      <a class="navbar-brand" href="{{ route('admin.dashboard') }}">Admin Penginapan</a>
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav me-auto">
          <li class="nav-item"><a class="nav-link" href="{{ route('kamar.index') }}">Data Kamar</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('pengunjung.index') }}">Data Pengunjung</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('booking.corporate') }}">Booking Corporate</a></li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="container py-4">
    @yield('content')
  </div>
</body>
</html>
