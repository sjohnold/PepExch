@foreach ($navigationMain ?? [] as $item)
    @continue(($item['is_visible'] ?? true) === false)
    @continue(($item['visibility'] ?? 'public') === 'auth' && !auth()->check())
    @continue(($item['visibility'] ?? 'public') === 'guest' && auth()->check())

    @if (($item['type'] ?? null) === 'category_dropdown')
        <li class="has-dropdown">
            <a href="javascript:void(0)">{{ __($item['label']) }}
                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="6" viewBox="0 0 10 6" fill="currentColor">
                    <path d="M5.00002 5.75076C4.80802 5.75076 4.61599 5.67778 4.46999 5.53079L0.469994 1.53079C0.176994 1.23779 0.176994 0.76275 0.469994 0.46975C0.762994 0.17675 1.23803 0.17675 1.53103 0.46975L5.001 3.93972L8.47097 0.46975C8.76397 0.17675 9.23901 0.17675 9.53201 0.46975C9.82501 0.76275 9.82501 1.23779 9.53201 1.53079L5.53201 5.53079C5.38401 5.67778 5.19202 5.75076 5.00002 5.75076Z" fill="currentColor" />
                </svg>
            </a>
            <div class="tp-megamenu-wrapper">
                <div class="row gx-0">
                    <div class="tp-megamenu-list">
                        <ul>
                            @foreach (($item['categories'] ?? []) as $category)
                                <li class="has-dropdown p-relative">
                                    <a href="{{ $category['url'] }}">
                                        <img src="{{ $category['thumbnail'] }}" alt="">
                                        {{ $category['name'] }}
                                        @if (count($category['children'] ?? []) > 0)
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="6" viewBox="0 0 10 6" fill="currentColor">
                                                <path d="M5.00002 5.75076C4.80802 5.75076 4.61599 5.67778 4.46999 5.53079L0.469994 1.53079C0.176994 1.23779 0.176994 0.76275 0.469994 0.46975C0.762994 0.17675 1.23803 0.17675 1.53103 0.46975L5.001 3.93972L8.47097 0.46975C8.76397 0.17675 9.23901 0.17675 9.53201 0.46975C9.82501 0.76275 9.82501 1.23779 9.53201 1.53079L5.53201 5.53079C5.38401 5.67778 5.19202 5.75076 5.00002 5.75076Z" fill="currentColor" />
                                            </svg>
                                        @endif
                                    </a>
                                    @if (count($category['children'] ?? []) > 0)
                                        <ul class="sub-dropdown p-absolute">
                                            @foreach ($category['children'] as $sub)
                                                <li>
                                                    <a href="{{ $sub['url'] }}">
                                                        <img src="{{ $sub['thumbnail'] }}" alt="">
                                                        {{ $sub['name'] }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </li>
    @else
        @php
            $routeName = $item['route_name'] ?? null;
            $isActive = $routeName ? request()->routeIs($routeName) : false;
        @endphp
        <li class="{{ $isActive ? 'active' : '' }}">
            <a href="{{ $item['url'] ?? '#' }}" target="{{ $item['target'] ?? '_self' }}">{{ __($item['label']) }}</a>
        </li>
    @endif
@endforeach
