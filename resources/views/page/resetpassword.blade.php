@extends('color.resetpass')
@section('title', 'Reset Password')

@section('konten')
<div class="logo">
  <img src="{{ asset('img/logo_ventbee_baru.png') }}" alt="Ventbee Logo">
</div>
<div class="reset-box">
  <h2>Reset Password</h2>
  <p>Silakan masukkan kredensial Anda di bawah untuk melanjutkan.</p>
  <form action="{{ route('user.password.update', $user->id) }}" method="POST">
    @csrf
    <div class="password-group">
      <label for="password">New Password</label>
      <input type="password" id="password" name="password" placeholder="Masukkan password baru Anda" required>
      <i id="togglepassword" class="bi bi-eye-slash toggle-icon"></i>
    </div>
    <div class="password-group">
      <label for="password_confirm">Re-enter New Password</label>
      <input type="password" id="password_confirm" name="password_confirmation" placeholder="Masukkan kembali password baru Anda" required>
      <i id="toggleconfirm" class="bi bi-eye-slash toggle-icon"></i>
    </div>
    <div class="click-but">
      <button type="submit">Reset Password</button>
    </div>
  </form>
</div>

<script src="{{asset('js/resetpass.js')}}"></script>
@endsection