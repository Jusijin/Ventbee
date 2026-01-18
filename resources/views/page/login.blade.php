@extends('color.logincss')
@section('title', 'Login Account')

@section('konten')
<div class="logo">
  <img src="{{ asset('img/logo_ventbee_baru.png') }}" alt="Ventbee Logo">
</div>

<div class="login-box">
  <h2>Login!</h2>
  <p>Silakan masukkan kredensial Anda di bawah untuk melanjutkan.</p>
  <form action="login" method="POST">
    @csrf
    <div class="form-group">
      <label for="email">Email</label>
      <input type="email" autofocus id="email" name="email" placeholder="Masukkan username Anda" required>
    </div>
    <div class="password-group">
      <label for="password">Password</label>
      <input type="password" id="password" name="password" placeholder="Masukkan password Anda" required>
      <i id="togglepassword" class="bi bi-eye-slash toggle-icon"></i>
    </div>
    <div class="login-options">
      <label><input type="checkbox" name="remember">Remember me</label>
      <a href="{{ route('user.password') }}">Forgot Password?</a>
    </div>
    <div class="click-but">
      <button type="submit" onclick="this.disabled=true;this.form.submit();"
      >Login</button>
    </div>
    <div class="click-register">
      <p style="text-align">
      Belum punya akun?
        <a href="{{ route('user.register') }}">Register</a>          
      </p>
    </div>
  </form>
</div>

@if (session('error'))
    <div class="alert-login">
        {{ session('error') }}
    </div>
@endif

<script src="{{asset('js/login.js')}}"></script>

@endsection