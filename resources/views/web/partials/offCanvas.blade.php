 <!-- offcanvas start -->
 <div class="tp-offcanvas-area">
     <div class="tp-offcanvas-wrapper">
         <div class="tp-offcanvas-header d-flex justify-content-between align-items-center mb-90">
             <div class="tp-offcanvas-logo">
                 <a href="javascript:void(0)">
                     <img src="{{ $applogo->logo_url ? $applogo->logo_url : asset('assets/frontend/img/logo/header-logo.png') }}"
                         alt="" style="max-height: 32px">
                 </a>
             </div>
             <div class="tp-offcanvas-close">
                 <button>
                     <i class="fal fa-times"></i>
                 </button>
             </div>
         </div>
         <div class="rs-header-top-right d-flex align-items-center justify-content-end">
             <a href="{{ route('user.show-notifications') }}" class="rs-header-notification d-flex align-items-center">
                 <i class="rs-header-notification-icon">
                     <img src="{{ asset('assets/frontend/img/icon/bell.svg') }}" alt="">
                 </i>
                 <span>{{ __('Notification') }}</span>
                 <cite>
                     {{ getUnreadNotificationsCount(true) }}
                 </cite>
             </a>
             <a href="{{route('wishlist.index')}}" class="rs-header-heart rs-header-heart-2 d-flex align-items-center p-relative">
                 <i class="rs-header-heart-icon">
                     <img src="{{ asset('assets/frontend/img/icon/heart.svg') }}" alt="">
                 </i>
                 <span class="alert-badge alert-badge-2 wishlist-count" id="wishlist-count">
                     {{ auth()->check()
                         ? \App\Models\Wishlist::where('user_id', auth()->id())->count()
                         : count(Cache::get('wishlist_guest', [])) }}
                 </span>
             </a>
             <a href="{{ route('product-ad') }}" class="rs-header-btn rs-btn d-flex align-items-center">
                 {{ __('Post Your Ad') }}
                 <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                     fill="none">
                     <path
                         d="M15 7H9V1C9 0.448 8.552 0 8 0C7.448 0 7 0.448 7 1V7H1C0.448 7 0 7.448 0 8C0 8.552 0.448 9 1 9H7V15C7 15.552 7.448 16 8 16C8.552 16 9 15.552 9 15V9H15C15.552 9 16 8.552 16 8C16 7.448 15.552 7 15 7Z"
                         fill="currentColor" />
                 </svg>
             </a>
         </div>
         <div class="tp-offcanvas-menu d-xl-none mb-50">
             <nav></nav>
         </div>
         <div class="tp-offcanvas-content mb-50 d-none d-xl-block">
             <h2 class="tp-offcanvas-title">
                 {{ __('hello-there') }}
             </h2>
             <p>
                 {{ __('The IT agency industry is evolving at an incredible pace, showing no signs of slowing down') }}.
             </p>
         </div>


         <div class="tp-offcanvas-info mb-50">
             <h3 class="tp-offcanvas-info-title mb-15">
                 {{ __('information') }}
             </h3>
             <span>
                 <a href="tel:+62427634206">
                     {{ $footerContact->value }}
                 </a>
             </span>
             <span>
                 <a href="mailto:support@gmail.com">
                     {{ $footerSupportMail->value }}
                 </a>
             </span>
             <span>
                 <a href="javascript:void(0)">
                     {{ $footerAddress->value }}
                 </a>
             </span>
         </div>

         <div class="tp-offcanvas-social">
             <h3 class="tp-offcanvas-social-title mb-15">
                 {{ __('follow us') }}
             </h3>


             @if (isset($socialLinks) && is_array($socialLinks))
                 @foreach ($socialLinks as $item)
                     @php
                         $item = (object) $item;
                     @endphp
                     @if (!empty($item->url))
                         <a href="{{ $item->url }}" target="_blank" rel="noopener noreferrer"
                             class="social-icon-link social-{{ $item->icon }}" title="{{ $item->label }}">
                             <i class="fab fa-{{ $item->icon }}"></i>
                         </a>
                     @endif
                 @endforeach
             @endif
         </div>
     </div>
 </div>
 <!-- offcanvas end -->
