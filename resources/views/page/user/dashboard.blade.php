@extends('layout.master')
@section('title', 'Dashboard')

@section('konten')
<h5 class="name-title" style="padding: 5px">{{ __('dashboard.dashb') }}</h5>
<div class="row g-4 mb-4" style="padding: 10px; align-items: center;">
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6>{{__('dashboard.allevent') }}</h6>
                <h3>{{ $totalEvent }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6>{{__('dashboard.followevent') }}</h6>
                <h3>{{ $onProgress }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6>{{__('dashboard.finishevent') }}</h6>
                <h3>{{ $finished }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="card mt-4" style="padding: 10px">
    <div class="card-header">
        <strong>{{__('dashboard.regisevent') }}</strong>
    </div>

    <div class="table-responsive">
        <table class="table table-striped align-middle mb-0">
            <thead>
                <tr>
                    <th>{{__('dashboard.no') }}</th>
                    <th>{{__('dashboard.category') }}</th>
                    <th>{{__('dashboard.namevent') }}</th>
                    <th>{{__('dashboard.eventdate') }}</th>
                    <th>{{__('dashboard.status') }}</th>
                    <th>{{__('dashboard.action') }}</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($events as $event)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $event->category->name ?? '-' }}</td>
                    <td>{{ $event->event_name }}</td>
                    <td>{{ $event->date->format('d M Y') }}</td>
                    <td>
                        <span class="badge bg-success">
                            {{ $event->pivot->status }}
                        </span>
                    </td>
                    <td>
                        <a href="#" class="btn btn-sm btn-primary">Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">
                        {{__('dashboard.notregis') }}
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection