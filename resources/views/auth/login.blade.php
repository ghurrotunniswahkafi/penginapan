@extends('layouts.app')
@section('content')
<div class="container">
  <div class="row justify-content-center mt-5">
    <div class="col-md-6">
      <div class="rounded-panel text-center p-5">
        <h3>Admin Login</h3>
        <form method="POST" action="{{ route('auth.login.post') }}">
          @csrf
          <div class="mb-3"><input type="email" name="email" class="form-control" placeholder="Email" required></div>
          <div class="mb-3"><input type="password" name="password" class="form-control" placeholder="Password" required></div>
          <button class="btn btn-primary w-100">Login</button>
        </form>
        <div class="mt-3 text-muted" style="font-size:13px">Gunakan admin@example.com / password123</div>
      </div>
    </div>
  </div>
</div>
@endsection
