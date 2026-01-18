@extends('layout.master')
@section('title', 'Detail Event')

@section('konten')
<h5 class="name-title">{{__('admindash.detail_event') }}</h5>
<div class="container mt-4">
    {{-- Back Button --}}
    <a href="{{ route('user.events.index') }}" class="btn btn-outline-secondary mb-3">
        <i class="bi bi-arrow-left"></i> {{__('addevent.back') }}
    </a>
    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            {{-- Header --}}
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <h3 class="fw-bold">{{ $event->event_name }}</h3>
                    <span class="badge bg-primary">
                        {{ $event->category->name ?? 'Tanpa Kategori' }}
                    </span>
                </div>

                {{-- Status --}}
                <span class="badge 
                    @if($event->status === 'open') bg-success
                    @elseif($event->status === 'closed') bg-danger
                    @elseif($event->status === 'on_progress') bg-warning
                    @else bg-secondary
                    @endif">
                    {{ strtoupper($event->status) }}
                </span>
            </div>

            <hr>

            {{-- Event Info --}}
            <div class="row g-3">
                <div class="col-md-6">
                    <p><strong>{{__('addevent.location') }}:</strong> {{ $event->location }}</p>
                    <p><strong>{{__('addevent.eventdate') }}:</strong>
                        {{ \Carbon\Carbon::parse($event->date)->format('d M Y H:i') }}
                    </p>
                </div>

                <div class="col-md-6">
                    <p><strong>{{__('addevent.registopen') }}:</strong>
                        {{ \Carbon\Carbon::parse($event->registration_open)->format('d M Y H:i') }}
                    </p>
                    <p><strong>{{__('addevent.registclose') }}:</strong>
                        {{ \Carbon\Carbon::parse($event->registration_close)->format('d M Y H:i') }}
                    </p>
                </div>
            </div>

            <hr>

            {{-- Description --}}
            <div class="mb-4">
                <h5>{{__('addevent.description') }}</h5>
                <p class="text-muted" style="white-space: pre-line;">
                    {{ $event->description }}
                </p>
            </div>

            {{-- Action --}}
            <div class="d-flex gap-2">
                @php
                    $now = \Carbon\Carbon::now();
                    $isClosed = $event->status !== 'open'||
                    ($event->registration_open && $now->lt($event->registration_open)) ||
                    ($event->registration_close && $now->gt($event->registration_close)) ||
                    ($event->quota_taken >= $event->total_quota);
                @endphp
                @if($isRegistered)
                    <button class="btn btn-success" disabled>
                        <i class="bi bi-check-circle"></i> {{__('addevent.registopen') }}
                    </button>
                
                @elseif($isClosed)
                    <button class="btn btn-secondary" disabled>
                        <i class="bi bi-lock"></i> {{__('addevent.registclose') }}
                    </button>

                @else
                    <form action="{{ route('user.events.register', $event->id) }}" method="POST">
                        @csrf
                        <button class="btn btn-primary">
                            <i class="bi bi-pencil-square"></i> {{__('admindash.addevent') }}
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection