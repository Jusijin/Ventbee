@extends('layout.master')
@section('title', 'Profile')

@section('konten')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">

<div class="profile-page-layout">
    <div class="profile-main">
        <h2 class="profile-title">Informasi Akun</h2>

        <div class="profile-header">
            <div class="avatar-wrapper">
                <img src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : asset('default.jpg') }}" class="profile-photo" id="photo-preview">

                <label for="file-input" class="edit-icon">
                    <i class="bi bi-pencil-fill"></i>
                </label>
                <input type="file" id="file-input" name="profile_photo" class="hidden-input" onchange="previewImage(event)" form="update-form" accept="image/*">
            </div>
            
            <div class="profile-info-text">
                <h3>{{ $user->name }}</h3>
                <p class="role-badge">Pengguna</p>
            </div>
        </div>

        <form action="{{ route('user.profile.update') }}" id="update-form" method="POST" enctype="multipart/form-data" class="profile-form">
            @csrf
            <div class="form-group">
                <input type="text" name="name" value="{{ $user->name }}" class="input-pill" placeholder="Nama Lengkap">
            </div>

            <div class="form-group">
                <input type="date" name="birth_date" value="{{ $user->birth_date }}" class="input-pill">
            </div>

            <div class="form-group">
                <select name="gender" class="input-pill">
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="male" {{ $user->gender=='male'?'selected':'' }}>Laki-laki</option>
                    <option value="female" {{ $user->gender=='female'?'selected':'' }}>Perempuan</option>
                </select>
            </div>

            <div class="form-group">
                <input type="email" value="{{ $user->email }}" class="input-pill" placeholder="Alamat Email" readonly>
            </div>

            <div class="form-group">
                <input type="text" name="phone" value="{{ $user->phone }}" class="input-pill" placeholder="Nomor Telepon" inputmode="numeric">
            </div>

            <div class="form-group">
                <input type="text" name="address" value="{{ $user->address }}" class="input-pill" placeholder="Alamat Lengkap">
            </div>

            <div class="form-actions">
                <a href="{{ route('user.dashboard') }}" class="btn-link">Batal Perubahan</a>
                <button type="submit" class="btn-save">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

@if(session('success'))
    <div class="alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert-error">
        {{ session('error') }}
    </div>
@endif

<script src="{{asset('js/profile.js')}}"></script>
@endsection