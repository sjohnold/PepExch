 <!-- sticky-header-start -->
 <div class="rs-header-sticky">
     <div class="container">
         <div class="row align-items-center justify-content-between">
             <div class="col-xl-3 col-lg-2 col-md-4 col-6">
                 <div class="rs-header-logo">
                     <a href="{{ route('home') }}">
                         <img src="{{ $applogo->logo_url ? $applogo->logo_url : asset('assets/frontend/img/logo/header-logo.png') }}"
                             alt="" style="max-height: 32px">
                     </a>
                 </div>
             </div>
             <div class="col-xl-6 col-lg-7 d-none d-lg-block">
                 <div class="rs-header-main-menu d-none d-lg-block">
                     <nav class="">
                         <ul>
                             <li class="{{ request()->routeIs('home') ? 'active' : '' }}">
                                 <a href="{{ route('home') }}">{{ __('Home') }}</a>
                             </li>
                             <li class="has-dropdown">
                                 <a href="javascript:void(0)">{{ __('Category') }}
                                     <svg xmlns="http://www.w3.org/2000/svg" width="10" height="6"
                                         viewBox="0 0 10 6" fill="currentColor">
                                         <path
                                             d="M5.00002 5.75076C4.80802 5.75076 4.61599 5.67778 4.46999 5.53079L0.469994 1.53079C0.176994 1.23779 0.176994 0.76275 0.469994 0.46975C0.762994 0.17675 1.23803 0.17675 1.53103 0.46975L5.001 3.93972L8.47097 0.46975C8.76397 0.17675 9.23901 0.17675 9.53201 0.46975C9.82501 0.76275 9.82501 1.23779 9.53201 1.53079L5.53201 5.53079C5.38401 5.67778 5.19202 5.75076 5.00002 5.75076Z"
                                             fill="currentColor" />
                                     </svg>
                                 </a>
                                 <div class="tp-megamenu-wrapper ">
                                     <div class="row gx-0">
                                         <div class="tp-megamenu-list">
                                             <ul>
                                                 @foreach ($categories as $category)
                                                     <li class="has-dropdown p-relative">
                                                         <a href="{{ route('products', $category->id) }}">
                                                             <img src="{{ $category->thumbnailPath }}" alt="">
                                                             {{ $category->name }}

                                                             @if ($category->child->count() > 0)
                                                                 <svg xmlns="http://www.w3.org/2000/svg" width="10"
                                                                     height="6" viewBox="0 0 10 6"
                                                                     fill="currentColor">
                                                                     <path
                                                                         d="M5.00002 5.75076C4.80802 5.75076 4.61599 5.67778 4.46999 5.53079L0.469994 1.53079C0.176994 1.23779 0.176994 0.76275 0.469994 0.46975C0.762994 0.17675 1.23803 0.17675 1.53103 0.46975L5.001 3.93972L8.47097 0.46975C8.76397 0.17675 9.23901 0.17675 9.53201 0.46975C9.82501 0.76275 9.82501 1.23779 9.53201 1.53079L5.53201 5.53079C5.38401 5.67778 5.19202 5.75076 5.00002 5.75076Z"
                                                                         fill="currentColor" />
                                                                 </svg>
                                                             @endif
                                                         </a>

                                                         @if ($category->child->count() > 0)
                                                             <ul class="sub-dropdown p-absolute">
                                                                 @foreach ($category->child as $sub)
                                                                     <li>
                                                                         <a href="{{ route('products', $sub->id) }}">
                                                                             <img src="{{ $sub->thumbnailPath }}"
                                                                                 alt="">
                                                                             {{ $sub->name }}
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
                             <li class="{{ request()->routeIs('products') ? 'active' : '' }}">
                                 <a href="{{ route('products') }}">{{ __('Most Popular') }}</a>
                             </li>
                             <li class="{{ request()->routeIs('about.us') ? 'active' : '' }}">
                                 <a href="{{ route('about.us') }}">{{ __('About Us') }}</a>
                             </li>

                             <li class="{{ request()->routeIs('contact.us') ? 'active' : '' }}">
                                 <a href="{{ route('contact.us') }}">{{ __('Contact') }}</a>
                             </li>
                         </ul>
                     </nav>
                 </div>
             </div>
             <div class="col-xl-3 col-lg-3 col-md-8 col-6">
                 <div class="rs-header-sticky-right d-flex align-items-center justify-content-end">
                     @auth
                         <a href="{{ route('user.show-notifications') }}"
                             class="rs-header-notification d-flex align-items-center d-none d-md-block f_auto">
                             <i class="rs-header-notification-icon">
                                 <img src="{{ asset('assets/frontend/img/icon/bell.svg') }}" alt="">
                             </i>
                             <span class="alert-badge">{{ getUnreadNotificationsCount(true) }}</span>
                         </a>
                     @endauth

                     @auth
                         <a href="{{ route('wishlist.index') }}"
                             class="rs-header-notification d-flex align-items-center d-none d-md-block f_auto">
                             <i class="rs-header-notification-icon">
                                 <img src="{{ asset('assets/frontend/img/icon/heart.svg') }}" alt="">
                             </i>
                             <span class="alert-badge wishlist-count" id="wishlist-count">
                                 {{ $wishListcount }}
                             </span>
                         </a>
                     @endauth

                     @auth
                         <a href="{{ route('product-ad') }}"
                             class="rs-header-btn d-flex align-items-center d-none d-md-block f_auto"
                             style="margin-left: 22px !important">
                             {{ __('Post Your Ad') }}
                             <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                                 fill="none">
                                 <path
                                     d="M15 7H9V1C9 0.448 8.552 0 8 0C7.448 0 7 0.448 7 1V7H1C0.448 7 0 7.448 0 8C0 8.552 0.448 9 1 9H7V15C7 15.552 7.448 16 8 16C8.552 16 9 15.552 9 15V9H15C15.552 9 16 8.552 16 8C16 7.448 15.552 7 15 7Z"
                                     fill="white" />
                             </svg>
                         </a>
                     @else
                         <a onclick="toggleModal('sign_in_popup')"
                             class="rs-header-btn d-flex align-items-center d-none d-md-block f_auto">
                             {{ __('Post Your Ad') }}
                             <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                                 fill="none">
                                 <path
                                     d="M15 7H9V1C9 0.448 8.552 0 8 0C7.448 0 7 0.448 7 1V7H1C0.448 7 0 7.448 0 8C0 8.552 0.448 9 1 9H7V15C7 15.552 7.448 16 8 16C8.552 16 9 15.552 9 15V9H15C15.552 9 16 8.552 16 8C16 7.448 15.552 7 15 7Z"
                                     fill="white" />
                             </svg>
                         </a>
                     @endauth

                     <div class="tp-header-author p-relative">
                         <a href="javascript:void(0)" class="rs-header-abtar">
                             @if (auth()->check())
                                 <div class="tp-header-author-thumb-more p-absolute bg-white rounded shadow-sm"
                                     style="padding: 8px 0; min-width: 200px; box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;">

                                     <a href="{{ route('user.profile') }}"
                                         class="{{ request()->routeIs('user.profile') ? 'active-menu' : '' }}">
                                         <i class="fal fa-user"></i>
                                         {{ __('Profile') }}
                                     </a>

                                     <a href="{{ route('chat.index') }}"
                                         class="{{ request()->routeIs('chat.index') ? 'active-menu' : '' }}">
                                         <i class="fal fa-envelope"></i>
                                         {{ __('Messages') }}
                                     </a>

                                     <a href="{{ route('wishlist.index') }}"
                                         class="{{ request()->routeIs('wishlist.index') ? 'active-menu' : '' }}">
                                         <i class="fal fa-heart"></i>
                                         {{ __('Wishlists') }}
                                     </a>

                                     <a href="{{ route('user.my-ads') }}"
                                         class="{{ request()->routeIs('user.my-ads') ? 'active-menu' : '' }}">
                                         <i class="fal fa-bullhorn"></i>
                                         {{ __('My Ads') }}
                                     </a>



                                     <a href="javascript:void(0)" onclick="logout(this)" class="logout-link">
                                        <i class="fal fa-sign-out"></i>
                                        {{ __('Logout') }}

                                        <form method="POST" action="{{ route('user.logout') }}" style="display:none;">
                                            @csrf
                                        </form>
                                     </a>
                                 </div>

                                 <div
                                     class="tp-header-author-content mr-12 text-end d-flex align-items-center justify-content-between gap-2">
                                     <a href="#" class="tp-header-author-name d-block w_nowrap">
                                         {{ strlen(auth()->user()?->name) > 15 ? substr(auth()->user()?->name, 0, 15) . '...' : auth()->user()?->name ?? 'Guest' }}
                                         <br>
                                         <span>
                                             {{ auth()->user()?->getRoleNames()?->first() ?? 'User' }}
                                         </span>
                                     </a>
                                     <div class="tp-header-author-img p-relative">
                                         <img src="{{ auth()->user()->profilePhotoPath ?? asset('media/demo-img.png') }}"
                                             alt="{{ auth()->user()->profilePhotoPath ?? asset('media/demo-img.png') }}"
                                             class="border-radius-100">
                                     </div>
                                 </div>
                             @else
                                 <a onclick="toggleModal('sign_in_popup')"
                                     class="rs-sign-in-btn d-flex align-items-center justify-content-center gap-6">
                                     <i class="fas fa-sign-out-alt fs-4"></i>
                                     {{ __('Sign In') }}
                                 </a>
                             @endif
                         </a>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>
 <!-- sticky-header-end -->
