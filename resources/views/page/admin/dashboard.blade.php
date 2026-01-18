@extends('layout.master')
@section('title', 'Dashboard Admin')

@section('konten')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>{{ __('admindash.title')}}</h2>
        <a href="{{ route('admin.create') }}" class="btn btn-primary">{{ __('admindash.add_event')}}</a>
    </div>

    <form method="GET" class="row g-3 mb-4 align-items-end">
        {{-- Filter dari status --}}
        <div class="col-md-2">
            <label class="form-label">{{ __('admindash.status')}}</label>
            <select name="status" class="form-select">
                <option value="">{{ __('admindash.all')}}</option>
                @foreach(['open','closed','on_progress','finished'] as $st)
                    <option value="{{ $st }}"
                        {{ request('status') == $st ? 'selected' : '' }}>
                        {{ ucfirst($st) }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Filter dari kategori --}}
        <div class="col-md-2">
            <label class="form-label">{{ __('admindash.category')}}</label>
            <select name="category" class="form-select">
                <option value="">{{ __('admindash.all')}}</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}"
                        {{ request('category') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Filter dari keyword --}}
        <div class="col-md-3">
            <label class="form-label">{{ __('admindash.keyword')}}</label>
            <input type="text"
                name="keyword"
                value="{{ request('keyword') }}"
                class="form-control"
                placeholder="{{ __('admindash.boxevent')}}">
        </div>

        {{-- Filter Button --}}
        <div class="col-md-2">
            <button class="btn btn-success w-100">
                <i class="bi bi-funnel"></i> {{ __('admindash.filter')}}
            </button>
        </div>
    </form>

    <form method="GET" class="mb-3">
        <label>{{ __('admindash.show')}}</label>
        <select name="show" onchange="this.form.submit()">
            @foreach([10 ,20 ,50 ,100 ] as $val)
                <option value="{{ $val }}" {{ request('show')==$val?'selected':'' }}>
                    {{ $val }}
                </option>
            @endforeach
        </select>

        {{-- keep filters --}}
        <input type="hidden" name="status" value="{{ request('status') }}">
        <input type="hidden" name="category" value="{{ request('category') }}">
        <input type="hidden" name="keyword" value="{{ request('keyword') }}">
    </form>


    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>{{ __('admindash.no')}}</th>
                <th>{{ __('admindash.event')}}</th>
                <th>{{ __('admindash.category')}}</th>
                <th>{{ __('admindash.date')}}</th>
                <th>{{ __('admindash.quota')}}</th>
                <th>{{ __('admindash.status')}}</th>
                <th class="text-center">{{ __('admindash.action')}}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($events as $event)
            <tr>
                <td>{{ $loop->iteration + $events->firstItem() - 1 }}</td>
                <td>{{ $event->event_name }}</td>
                <td>{{ $event->category->name ?? '-' }}</td>
                <td>{{ $event->date->format('d M Y') }}</td>
                <td>
                    {{ $event->quota_taken }} / {{ $event->total_quota }}
                </td>
                <td>
                    <span class="badge bg-{{ 
                        $event->status == 'open' ? 'success' :
                        ($event->status == 'on_progress' ? 'warning' :
                        ($event->status == 'finished' ? 'secondary' : 'danger'))
                    }}">
                        {{ ucfirst($event->status) }}
                    </span>
                </td>
                <td class="text-center">
                    <a href="{{ route('admin.participants', $event->id) }}"
                    class="btn btn-info btn-sm text-white">
                        <i class="bi bi-people"></i>
                    </a>

                    <a href="{{ route('admin.edit', $event->id) }}"
                    class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil"></i>
                    </a>

                    <form id="delete-form-{{ $event->id }}" 
                            action="{{ route('admin.delete', $event->id) }}" 
                            method="POST" 
                            class="d-inline"> 
                        @csrf @method('DELETE') 
                        <button type="button" 
                                class="btn btn-danger btn-sm" 
                                onclick="confirmDelete({{ $event->id }})"><i class="bi bi-trash"></i>
                        </button> 
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center text-muted">
                    {{ __('admindash.info_event')}}
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
<div class="d-flex justify-content-between align-items-center mt-3">
    <div>
        {{ __('admindash.showing')}} {{ $events->firstItem() }} - {{ $events->lastItem() }}
        {{ __('admindash.of')}} {{ $events->total() }} {{ __('admindash.item')}}
    </div>
    <div>
        {{ $events->links('pagination::bootstrap-4') }}
    </div>
</div>
</div>
@endsection