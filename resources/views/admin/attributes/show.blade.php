@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">🔎 {{ __('Attribute Details') }}</h2>

    <div class="card shadow-sm rounded">
        <div class="card-body">
            <h5 class="card-title fw-bold">{{ $attribute->name }}</h5>

            <p><strong>{{ __('Category:') }}</strong>
                {{ $attribute->category ? $attribute->category->name : __('N/A') }}
            </p>

            <p><strong>{{ __('Parent Attribute:') }}</strong>
                {{ $attribute->parent ? $attribute->parent->name : __('None') }}
            </p>

            <p><strong>{{ __('Created At:') }}</strong> {{ $attribute->created_at->format('d M Y, h:i A') }}</p>
            <p><strong>{{ __('Updated At:') }}</strong> {{ $attribute->updated_at->format('d M Y, h:i A') }}</p>
        </div>

        <div class="card-footer d-flex justify-content-between">
            <a href="{{ route('attributes.index') }}" class="btn btn-secondary">⬅ {{ __('Back') }}</a>
            <div>
                <a href="{{ route('attributes.edit', $attribute->id) }}" class="btn btn-warning">✏ {{ __('Edit') }}</a>

                <form action="{{ route('attributes.destroy', $attribute->id) }}" method="POST"
                      style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"
                        onclick="return confirm('{{ __('Are you sure to delete this attribute?') }}')">
                        🗑 {{ __('Delete') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
