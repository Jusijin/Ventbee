@extends('layout.master')
@section('title', 'Edit Event')

@section('konten')
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>{{ __('addevent.editevent')}}</h4>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary btn-sm">
            ← {{ __('addevent.back')}}
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.update', $event->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">{{ __('addevent.namevent')}}</label>
                        <input type="text" name="event_name" class="form-control"
                            value="{{ old('event_name', $event->event_name) }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">{{ __('addevent.category')}}</label>
                        <select name="category_id" class="form-select" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id'), $event->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">{{ __('addevent.registopen')}}</label>
                        <input type="datetime-local" name="registration_open" class="form-control"
                            value="{{ old('registration_open', $event->registration_open?->format('Y-m-d\TH:i')) }}"
                            required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">{{ __('addevent.registclose')}}</label>
                        <input type="datetime-local" name="registration_close" class="form-control"
                            value="{{ old('registration_close', $event->registration_close?->format('Y-m-d\TH:i')) }}"
                            required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">{{ __('addevent.eventdate')}}</label>
                        <input type="datetime-local" name="date" class="form-control"
                            value="{{ old('date', $event->date?->format('Y-m-d\TH:i')) }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">{{ __('addevent.location')}}</label>
                        <input type="text" name="location" class="form-control"
                            value="{{ old('location', $event->location) }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">{{ __('addevent.description')}}</label>
                    <textarea name="description" rows="3" class="form-control" required>
                        {{ old('description', $event->description) }}
                    </textarea>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">{{ __('addevent.allquota')}}</label>
                        <input type="number" name="total_quota" class="form-control"
                            value="{{ old('total_quota', $event->total_quota) }}" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">{{ __('addevent.status')}}</label>
                        <select name="status" class="form-select" required>
                            <option value="open" {{ $event->status == 'open' ? 'selected' : '' }}>{{ __('addevent.open')}}</option>
                            <option value="closed" {{ $event->status == 'closed' ? 'selected' : '' }}>{{ __('addevent.closed')}}</option>
                            <option value="on_progress" {{ $event->status == 'on_progress' ? 'selected' : '' }}>{{ __('addevent.onprogress')}}</option>
                            <option value="finished" {{ $event->status == 'finished' ? 'selected' : '' }}>{{ __('addevent.finished')}}</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4 d-flex justify-content-end gap-2">
                    <button type="submit" class="btn btn-warning text-white px-4">
                        {{ __('addevent.update')}}
                    </button>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary px-4">
                        {{ __('addevent.back')}}
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection