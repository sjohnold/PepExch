@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>{{ __('Edit Announcement') }}</h3>

    <form action="{{ route('announcements.update', $announcement->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">{{ __('Title') }}</label>
            <input type="text"
                   name="title"
                   id="title"
                   value="{{ old('title', $announcement->title) }}"
                   class="form-control"
                   required>
        </div>

        <div class="mb-3">
            <label for="message" class="form-label">{{ __('Message') }}</label>
            <textarea name="message"
                id="message"
                rows="4"
                class="form-control"
                required>{{ old('message', $announcement->message) }}
            </textarea>
        </div>

        <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
        <a href="{{ route('announcements.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
    </form>
</div>
@endsection
