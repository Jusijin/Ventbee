@extends('layout.master')
@section('title', 'History Event')

{{-- PERBAIKAN: Gunakan 'konten' agar sesuai dengan master layout Anda --}}
@section('konten') 

<div class="container-fluid px-4">
    <h1 class="mt-4">History Event</h1>
    <ol class="breadcrumb mb-4">
        {{-- Pastikan route ini benar 'user.dashboard' --}}
        <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">History Event</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-history me-1"></i>
            Daftar Event yang Telah Selesai
        </div>
        <div class="card-body">
            @if(isset($events) && $events->count() > 0)
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Event</th>
                            <th>Kategori</th>
                            <th>Tanggal</th>
                            <th>Lokasi</th>
                            <th>Status Partisipasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($events as $index => $event)
                        <tr>
                            <td>{{ $events->firstItem() + $index }}</td>
                            <td>{{ $event->event_name }}</td>
                            <td>{{ $event->category->name ?? '-' }}</td>
                            <td>{{ $event->date->format('d M Y') }}</td>
                            <td>{{ $event->location }}</td>
                            <td>
                                <span class="badge bg-success">Selesai</span>
                            </td>
                            <td>
                                <a href="#" class="btn btn-sm btn-info text-white">
                                    Detail
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                {{-- Pagination --}}
                <div class="d-flex justify-content-end">
                    {{ $events->links() }}
                </div>
            @else
                <div class="alert alert-info text-center">
                    Belum ada history event.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection