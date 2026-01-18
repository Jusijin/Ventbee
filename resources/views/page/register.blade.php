@extends('color.signup')
@section('title', 'Register Account')

@section('konten')
<div class="logo">
  <img src="{{ asset('img/logo_ventbee_baru.png') }}" alt="Ventbee Logo">
</div>

<div class="register-box">
  <h2>Register Account</h2>
  <p>Silakan masukkan kredensial Anda di bawah untuk melanjutkan.</p>
  <form action="register" method="POST">
    @csrf
    <div class="form-group">
      <label for="name">Name</label>
      <input type="name" id="name" name="name" placeholder="Masukkan nama Anda" required>
    </div>
    <div class="form-group">
      <label for="email">Email</label>
      <input type="email" autofocus id="email" name="email" placeholder="Masukkan username Anda" required>
    </div>
    <div class="password-group">
      <label for="password">Password</label>
      <input type="password" id="password" name="password" placeholder="Masukkan password Anda" required>
      <i id="togglepassword" class="bi bi-eye-slash toggle-icon"></i>
    </div>
    <div class="password-group">
      <label for="password_confirm">Re-enter Password</label>
      <input type="password" id="password_confirm" name="password_confirmation" placeholder="Masukkan kembali password Anda" required>
      <i id="toggleconfirm" class="bi bi-eye-slash toggle-icon"></i>
    </div>
    <div class="click-but">
      <button type="submit" onclick="this.disabled=true;this.form.submit();"
      >Sign Up</button>
    </div>
    <div class="click-login">
      <p style="text-align">
        Sudah punya akun?
        <a href="{{ route('user.login') }}">Login</a>
      </p>
    </div>
  </form>
</div>

@if (session('error'))
    <div class="alert-register">
        {{ session('error') }}
    </div>
@endif

<script src="{{asset('js/register.js')}}"></script>

@endsection