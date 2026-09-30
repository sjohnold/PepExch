@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="fw-bold text-primary">{{ __('Add Attribute') }}</h2>

    <form action="{{ route('attributes.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>{{ __('Attribute Name') }}</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}">
            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label>{{ __('Select Category') }}</label>
            <select name="category_id" class="form-control">
                <option value="">{{ __('-- Select Category --') }}</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label>{{ __('Parent Attribute (optional)') }}</label>
            <select name="parent_id" class="form-control">
                <option value="">{{ __('-- None --') }}</option>
                @foreach($attributes as $attr)
                    <option value="{{ $attr->id }}" {{ old('parent_id') == $attr->id ? 'selected' : '' }}>
                        {{ $attr->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-success">{{ __('Save') }}</button>
        <a href="{{ route('attributes.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
    </form>
</div>
@endsection
