@extends('color.forgotpassword')
@section('title', 'Forgot Password')

@section('konten')
<div class="logo">
  <img src="{{ asset('img/logo_ventbee_baru.png') }}" alt="Ventbee Logo">
</div>

<div class="forgot-box">
  <h2>Forgot Password</h2>
  <p>Silakan masukkan kredensial Anda di bawah untuk melanjutkan.</p>
  <form action="{{ route('user.password.check')}}" method="POST">
    @csrf
    <div class="form-group">
      <label for="email">Email</label>
      <input type="email" id="email" name="email" placeholder="Masukkan username Anda" required>
    </div>
    <div class="click-but">
      <button type="submit">Check Email</button>
    </div>
  </form>
</div>
@endsection