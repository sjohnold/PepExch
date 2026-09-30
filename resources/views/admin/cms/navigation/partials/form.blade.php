@php
    $value = fn ($field, $default = null) => old($field, $item?->{$field} ?? $default);
@endphp

<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">{{ __('Location') }}</label>
        <select name="location" class="form-select" required>
            @foreach (['main' => 'Main menu', 'sidebar' => 'SPA sidebar', 'footer' => 'Footer'] as $key => $label)
                <option value="{{ $key }}" @selected($value('location', 'main') === $key)>{{ __($label) }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label">{{ __('Parent') }}</label>
        <select name="parent_id" class="form-select">
            <option value="">{{ __('None') }}</option>
            @foreach ($parents as $parent)
                @continue($item && $parent->id === $item->id)
                <option value="{{ $parent->id }}" @selected((string) $value('parent_id') === (string) $parent->id)>
                    {{ $parent->location }} / {{ $parent->label }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label">{{ __('Title') }}</label>
        <input name="label" value="{{ $value('label') }}" class="form-control" required maxlength="120">
    </div>
    <div class="col-md-6">
        <label class="form-label">{{ __('Icon class') }}</label>
        <input name="icon" value="{{ $value('icon') }}" class="form-control" placeholder="fas fa-home" maxlength="120">
    </div>
    <div class="col-md-4">
        <label class="form-label">{{ __('Type') }}</label>
        <select name="type" class="form-select" required>
            @foreach (['route' => 'Route', 'url' => 'Custom URL', 'category_dropdown' => 'Category dropdown'] as $key => $label)
                <option value="{{ $key }}" @selected($value('type', 'route') === $key)>{{ __($label) }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label">{{ __('Route name') }}</label>
        <input name="route_name" value="{{ $value('route_name') }}" class="form-control" placeholder="home">
    </div>
    <div class="col-md-4">
        <label class="form-label">{{ __('Custom URL') }}</label>
        <input name="url" value="{{ $value('url') }}" class="form-control" placeholder="https://example.com">
    </div>
    <div class="col-md-4">
        <label class="form-label">{{ __('Order') }}</label>
        <input name="sort_order" value="{{ $value('sort_order', 0) }}" type="number" min="0" class="form-control">
    </div>
    <div class="col-md-4">
        <label class="form-label">{{ __('Visibility') }}</label>
        <select name="visibility" class="form-select" required>
            @foreach (['public' => 'Public', 'auth' => 'Auth only', 'guest' => 'Guests only'] as $key => $label)
                <option value="{{ $key }}" @selected($value('visibility', 'public') === $key)>{{ __($label) }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label">{{ __('Target') }}</label>
        <select name="target" class="form-select" required>
            <option value="_self" @selected($value('target', '_self') === '_self')>{{ __('Same tab') }}</option>
            <option value="_blank" @selected($value('target', '_self') === '_blank')>{{ __('New tab') }}</option>
        </select>
    </div>
    <div class="col-12">
        <label class="form-check">
            <input type="hidden" name="is_visible" value="0">
            <input type="checkbox" name="is_visible" value="1" class="form-check-input" @checked($value('is_visible', true))>
            <span class="form-check-label">{{ __('Visible') }}</span>
        </label>
    </div>
</div>
