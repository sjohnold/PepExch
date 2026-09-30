@extends('web.layouts.master')
@section('content')
<section class="rs-about-area pt-80 pb-100">
    <div class="container">
        
        <!-- Top Hero Section -->
        <div class="rs-about-top-content br-8 pt-32 pb-32 pl-24 pr-24 text-center" data-bg-color="#F8F9FB">
            <h1 class="rs-section-title fns-36 fnw-700 mb-12" data-color="{{ $themeColors['primary_color'] }}">
               {{ $page->name }}
            </h1>
            <span class="rs-section-sub-title fnw-600 fns-48 mb-16" data-color="#17181D">
                 {{ $page->data[0]->title }}
            </span>
            <p class="fns-20 max-w-800 mx-auto" data-color="#555">
                {{ __('Last updated:') }} {{ \Carbon\Carbon::parse($page->created_at)->format('F d, Y') }} {{ __('By accessing or using our platform, you agree to be bound by these terms.') }}
            </p>
        </div>

        <!-- Content Sections -->
        <div class="mt-5">
            {!! $page->data[0]->description !!}
        </div>
    </div>
</section>
@endsection

