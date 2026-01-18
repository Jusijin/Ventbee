<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('layout.favicon')
    <title>@yield('title')</title>
    @include('layout.bootstrap')
    <link rel="stylesheet" href="{{ asset('css/master.css')}}">
</head>
<body>
    <div class="d-flex">
        {{-- Bagian Sidebar --}}
        <aside class="sidebar">
            @include('layout.sidebar')
        </aside>

        <div class="main-wrapper">
            {{-- Bagian Header --}} 
            <header class="header">
               @include('layout.header')
            </header>

            {{-- Bagian Konten --}}
            <main class="content-area">
                @yield('konten')
            </main>
        </div>
    </div>
</body>
<script src="{{ asset('bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Fungsi Konfirmasi Hapus
    function confirmDelete(eventId) {
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Data event ini tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33', // Warna merah untuk hapus
            cancelButtonColor: '#3085d6', // Warna biru untuk batal
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika user klik "Ya", submit form-nya
                document.getElementById('delete-form-' + eventId).submit();
            }
        })
    }
</script>
</html>