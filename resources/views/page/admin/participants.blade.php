@extends('layout.master')
@section('title', 'Information User')

@section('konten') 
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>{{ __('addevent.user')}}: {{ $event->event_name }}</h3>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> {{ __('addevent.back')}}
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            @if($event->participants->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>{{ __('addevent.no')}}</th>
                                <th>{{ __('addevent.user')}}</th>
                                <th>{{ __('addevent.email')}}</th>
                                <th>{{ __('addevent.joindate')}}</th>
                                <th>{{ __('addevent.status')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($event->participants as $participant)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div class="fw-bold">{{ $participant->name }}</div>
                                </td>
                                <td>{{ $participant->email }}</td>
                                <td>{{ $participant->pivot->created_at->format('d M Y H:i') }}</td>
                                <td>
                                    <span class="badge bg-success rounded-pill">
                                        {{ $participant->pivot->status }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-warning text-center">
                    <i class="bi bi-info-circle me-2"></i> 
                    {{ __('addevent.info_part')}}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection