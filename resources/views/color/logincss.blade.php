<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @include('layout.favicon')
    <title>@yield('title')</title>
    @include('layout.bootstrap')
    <link rel="stylesheet" href="{{ asset('js/login.js')}}">
    <link rel="stylesheet" href="{{ asset('css/login.css')}}">
</head>
<body>
    @yield('konten')
</body>
</html>