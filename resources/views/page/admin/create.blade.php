@extends('layout.master')
@section('title', 'Create Event')

@section('konten')
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>{{ __('addevent.event')}}</h4>
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

            <form action="{{ route('admin.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">{{ __('addevent.namevent')}}</label>
                        <input type="text" name="event_name" class="form-control" 
                                value="{{ old('event_name') }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">{{ __('addevent.category')}}</label>
                        <select name="category_id" class="form-select" required>
                            <option value="">{{ __('addevent.info_category')}}</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                                value="{{ old('registration_open') }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">{{ __('addevent.registclose')}}</label>
                        <input type="datetime-local" name="registration_close" class="form-control" 
                                value="{{ old('registration_close') }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">{{ __('addevent.eventdate')}}</label>
                        <input type="datetime-local" name="date" class="form-control" 
                                value="{{ old('date') }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">{{ __('addevent.location')}}</label>
                        <input type="text" name="location" class="form-control" 
                               value="{{ old('location') }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">{{ __('addevent.description')}}</label>
                    <textarea name="description" rows="3" class="form-control" required>
                        {{ old('description') }}
                    </textarea>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">{{ __('addevent.allquota')}}</label>
                        <input type="number" name="total_quota" class="form-control" 
                               value="{{ old('total_quota')}}" min="1" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">{{ __('addevent.status')}}</label>
                        <select name="status" class="form-select" required>
                            <option value="open" {{ old('status') == 'open' ? 'selected' : '' }}>{{ __('addevent.open')}}</option>
                            <option value="closed" {{ old('status') == 'closed' ? 'selected' : '' }}>{{ __('addevent.closed')}}</option>
                            <option value="on_progress" {{ old('status') == 'on_progress' ? 'selected' : '' }}>{{ __('addevent.onprogress')}}</option>
                            <option value="finished" {{ old('status') == 'finished' ? 'selected' : '' }}>{{ __('addevent.finished')}}</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4 d-flex justify-content-end">
                    <button type="submit" class="btn btn-success px-4">
                        {{ __('addevent.save')}}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
