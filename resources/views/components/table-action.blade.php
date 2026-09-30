<div>
    <a href="{{ $route }}" class="btn btn-sm shadow-sm {{ $textColor }} fw-semibold"
        style="background-color: {{ $bgColor }}; border-radius: 8px; padding: 0.5rem 1rem; font-size: 0.85rem; transition: all 0.3s ease;"
        onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='{{ $hoverShadow }}';"
        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='';">
        @if ($icon)
            <i class="{{ $icon }} me-1"></i>
        @endif
        {{ __($text) }}
    </a>
</div>
