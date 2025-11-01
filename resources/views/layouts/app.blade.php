<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title','PESMA')</title>
  <style>
    body{margin:0;background:#faf7f6;font-family:ui-sans-serif,system-ui,-apple-system,"Segoe UI",Roboto,"Helvetica Neue",Arial}
    a{color:inherit;text-decoration:none}
  </style>
  {{-- Jika Anda pakai Vite, aktifkan ini:
  @vite(['resources/css/app.css','resources/js/app.js'])
  --}}
</head>
<body>
  @yield('content')
</body>
</html>
