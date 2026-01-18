@extends('layout.master')
@section('title', 'Events')

@section('konten')
<h5 class="name-title" style="padding: 5px">{{ __('dashboard.event') }}</h5>
<form method="GET" class="row g-3 mb-4">
    <div class="col-md-2">
        <label>{{__('admindash.status') }}</label>
        <select name="status" class="form-select">
            <option value="">{{__('admindash.all') }}</option>
            <option value="open" {{ request('status')=='open'?'selected':'' }}>{{ __('addevent.open')}}</option>
            <option value="closed" {{ request('status')=='closed'?'selected':'' }}>{{ __('addevent.closed')}}</option>
            <option value="on_progress" {{ old('status') == 'on_progress' ? 'selected' : '' }}>{{ __('addevent.onprogress')}}</option>
            <option value="finished" {{ old('status') == 'finished' ? 'selected' : '' }}>{{ __('addevent.finished')}}</option>
        </select>
    </div>

    <div class="col-md-3">
        <label>{{__('admindash.keyword') }}</label>
        <input type="text" name="keyword" class="form-control"
               value="{{ request('keyword') }}" placeholder="{{__('admindash.typekey') }}">
    </div>

    <div class="col-md-3">
        <label>{{__('admindash.category') }}</label>
        <select name="category" class="form-select">
            <option value="">{{__('admindash.all') }}</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}"
                    {{ request('category')==$cat->id?'selected':'' }}>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-2 d-flex align-items-end">
        <button class="btn btn-success">{{__('admindash.filter') }}</button>
    </div>
</form>

<form method="GET" class="mb-3">
    <label>{{__('admindash.show') }}</label>
    <select name="show" onchange="this.form.submit()">
        @foreach([10,20,50,100] as $val)
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

<table class="table table-bordered align-middle">
    <thead>
        <tr>
            <th>{{__('admindash.no') }}</th>
            <th>{{__('admindash.status') }}</th>
            <th>{{__('admindash.category') }}</th>
            <th>{{__('addevent.namevent') }}</th>
            <th>{{__('addevent.allquota') }}</th>
            <th>{{__('admindash.taken') }}</th>
            <th>{{__('addevent.registopen') }}</th>
            <th>{{__('addevent.registclose') }}</th>
            <th class="text-center">{{__('admindash.action') }}</th>
        </tr>
    </thead>

    <tbody>
    @forelse($events as $event)
        <tr>
            <td>{{ $loop->iteration + $events->firstItem() - 1 }}</td>
            <td>
                <span class="badge bg-warning">
                    {{ ucfirst($event->status) }}
                </span>
            </td>
            <td>{{ $event->category->name }}</td>
            <td>{{ $event->event_name }}</td>
            <td>{{ $event->total_quota }}</td>
            <td>{{ $event->quota_taken }}</td>
            <td>{{ \Carbon\Carbon::parse($event->registration_open)->format('d M Y') }}</td>
            <td>{{ \Carbon\Carbon::parse($event->registration_close)->format('d M Y') }}</td>
            <td class="text-center">
                <a href="{{ route('user.events.detail', $event->id) }}" class="btn btn-sm btn-outline-primary">Detail</a>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="10" class="text-center text-muted">
                {{__('admindash.info_event') }}
            </td>
        </tr>
    @endforelse
    </tbody>
</table>

<div class="d-flex justify-content-between align-items-center">
    <div>
        {{__('admindash.showing') }} {{ $events->firstItem() }} - {{ $events->lastItem() }}
        {{__('admindash.of') }} {{ $events->total() }} {{__('admindash.item') }}
    </div>

    <div>
        {{ $events->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection