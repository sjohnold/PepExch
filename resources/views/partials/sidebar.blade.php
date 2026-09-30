<div class="tp-sidebar-area tp-navy-blue-bg">

    <div class="tp-deashboard-head">
        <a href="#" class="tp-deashboard-logo mb-16 d-flex align-items-center">
            <img class="main__logo"
                src="{{ $applogo->logo_url ? $applogo->logo_url : 'https://placehold.jp/150x50.png' }}" alt="App Logo"
                style="max-height: 60px;">
            <img class="fav__icon" src="{{ $fav->fav_url ? $fav->fav_url : 'https://placehold.jp/150x50.png' }}"
                alt="App Logo" style="max-height: 60px;">
        </a>
        <div class="tp-deashboard-close-icon p-relative d-md-block d-lg-none">
            <i class="fal fa-times"></i>
        </div>
    </div>




    <div class="tp-sidebar-menu">
        <nav>
            <ul>
                {{-- Dashboard --}}
                <li class="tp-dropdown__menu-item mb-7">
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <div class="tp-sidebar-menu-left d-flex align-items-center">
                            <img style="transform: translateY(-2px);"
                                src="{{ asset('assets/img/sidebar/side-bar-01.svg') }}" alt="">
                            <span class="tp-sidebar-menu-list-title ml-7">{{ __('Dashboard') }}</span>
                        </div>
                    </a>
                </li>

                {{-- Users --}}
                <li
                    class="tp-dropdown__menu-item mb-7 {{ request()->routeIs('users.index') || request()->routeIs('users.trash') || request()->routeIs('users.edit') || request()->routeIs('users.show.reports') ? 'open' : '' }}">
                    <a href="#" class="tp-dropdown-toggle" data-toggle="dropdown">
                        <div class="tp-sidebar-menu-left d-flex align-items-center">
                            <i class="tp-sidebar-others-icon r-0 fas fa-users"></i>
                            <span class="tp-sidebar-menu-list-title ml-7">{{ __('Users') }}</span>
                        </div>
                        <i class="far fa-angle-right dropdown-icon"></i>
                    </a>

                    <ul class="tp-dropdown__menu">
                        {{-- List of Users --}}
                        <li
                            class="{{ request()->routeIs('users.*') && request()->route()->parameter('status') == null ? 'active' : '' }}">
                            <a href="{{ route('users.index') }}">
                                <div
                                    class="tp-sidebar-menu-left d-flex align-items-center justify-content-between w-100">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('assets/img/sidebar/side-bar-12.svg') }}" alt="">
                                        <span class="tp-sidebar-menu-list-title ml-7">{{ __('List Of Users') }}</span>
                                    </div>
                                    <span class="badge bg-primary">{{ countUser()['countNo'] }}</span>
                                </div>
                            </a>
                        </li>

                        {{-- Status wise Users --}}
                        @foreach (\App\Enums\UserStatus::cases() as $userStatus)
                            @php
                                $countValue = countUser($userStatus->value);
                            @endphp
                            <li
                                class="{{ request()->routeIs('users.index') && request()->route()->parameter('status') == $userStatus->value ? 'active' : '' }}">
                                <a href="{{ route('users.index', $userStatus->value) }}">
                                    <div
                                        class="tp-sidebar-menu-left d-flex align-items-center justify-content-between w-100">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('assets/img/sidebar/side-bar-06.svg') }}"
                                                alt="">
                                            <span
                                                class="tp-sidebar-menu-list-title ml-7">{{ $userStatus->label() }}</span>
                                        </div>
                                        <span class="badge {{ $countValue['color'] }} rounded-pill">
                                            {{ $countValue['countNo'] }}
                                        </span>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
                {{-- Categories --}}
                <li class="tp-dropdown__menu-item mb-7">
                    <a href="{{ route('category.index') }}"
                        class="{{ request()->routeIs('category.*') ? 'active' : '' }}">
                        <div class="tp-sidebar-menu-left d-flex align-items-center">
                            <i class="tp-sidebar-others-icon r-0 fas fa-th-large"></i>
                            <span class="tp-sidebar-menu-list-title ml-7">{{ __('Categories') }}</span>
                        </div>
                    </a>
                </li>

                {{-- Colors --}}
                <li class="tp-dropdown__menu-item mb-7 ">
                    <a href="{{ route('colors.index') }}"
                        class="{{ request()->routeIs('colors.*') ? 'active' : '' }}">
                        <div class="tp-sidebar-menu-left d-flex align-items-center">
                            <i class="tp-sidebar-others-icon r-0 fas fa-palette"></i>
                            <span class="tp-sidebar-menu-list-title ml-7">{{ __('Colors') }}</span>
                        </div>
                    </a>
                </li>

                {{-- Brands --}}
                <li class="tp-dropdown__menu-item mb-7 ">
                    <a href="{{ route('brand.index') }}" class="{{ request()->routeIs('brand.*') ? 'active' : '' }}">
                        <div class="tp-sidebar-menu-left d-flex align-items-center">
                            <i class="tp-sidebar-others-icon r-0 fas fa-tags"></i>
                            <span class="tp-sidebar-menu-list-title ml-7">{{ __('Brands') }}</span>
                        </div>
                    </a>
                </li>

                {{-- Services --}}
                <li class="tp-dropdown__menu-item mb-7 ">
                    <a href="{{ route('services.index') }}"
                        class="{{ request()->routeIs('services.*') ? 'active' : '' }}">
                        <div class="tp-sidebar-menu-left d-flex align-items-center">
                            <i class="tp-sidebar-others-icon r-0 fas fa-briefcase"></i>
                            <span class="tp-sidebar-menu-list-title ml-7">{{ __('Services') }}</span>
                        </div>
                    </a>
                </li>
                {{-- Products  --}}
                <li
                    class="tp-dropdown__menu-item mb-7 {{ request()->routeIs('posts.*') || request()->routeIs('posts.trash') ? 'open' : '' }}">

                    <a href="#" class="tp-dropdown-toggle" data-toggle="dropdown">
                        <div class="tp-sidebar-menu-left d-flex align-items-center">
                            <i class="tp-sidebar-others-icon r-0 fas fa-handshake"></i>
                            <span class="tp-sidebar-menu-list-title ml-7">{{ __('Barter Posts') }}</span>
                        </div>
                        <i class="far fa-angle-right dropdown-icon"></i>
                    </a>

                    <ul class="tp-dropdown__menu">
                        {{-- All Posts --}}
                        <li
                            class="{{ request()->routeIs('posts.*') && request()->route()->parameter('status') == null ? 'active' : '' }}">
                            <a href="{{ route('posts.index') }}">
                                <div
                                    class="tp-sidebar-menu-left d-flex align-items-center justify-content-between w-100">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('assets/img/sidebar/side-bar-12.svg') }}" alt="">
                                        <span class="tp-sidebar-menu-list-title ml-7">{{ __('List Of Posts') }}</span>
                                    </div>
                                    <span class="badge bg-primary">{{ countPost()['countNo'] }}</span>
                                </div>
                            </a>
                        </li>

                        {{-- Status wise Posts --}}
                        @foreach (App\Enums\PostStatus::cases() as $postStatus)
                            @php $countValue = countPost($postStatus->value); @endphp
                            <li
                                class="{{ request()->routeIs('posts.*') && request()->route()->parameter('status') == $postStatus->value ? 'active' : '' }}">
                                <a href="{{ route('posts.index', $postStatus->value) }}">
                                    <div
                                        class="tp-sidebar-menu-left d-flex align-items-center justify-content-between w-100">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('assets/img/sidebar/side-bar-06.svg') }}"
                                                alt="">
                                            <span
                                                class="tp-sidebar-menu-list-title ml-7">{{ __($postStatus->value) }}</span>
                                        </div>
                                        <span class="badge {{ $countValue['color'] }} rounded-pill">
                                            {{ $countValue['countNo'] }}
                                        </span>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>


                {{-- Attributes --}}
                <li class="tp-dropdown__menu-item mb-7 ">
                    <a href="{{ route('attributes.index') }}"
                        class="{{ request()->routeIs('attributes.*') ? 'active' : '' }}">
                        <div class="tp-sidebar-menu-left d-flex align-items-center">
                            <i class="tp-sidebar-others-icon r-0 fas fa-sliders-h"></i>
                            <span class="tp-sidebar-menu-list-title ml-7">{{ __('Attributes') }}</span>
                        </div>
                    </a>
                </li>

                {{-- Support Tickets --}}
                <li class="tp-dropdown__menu-item mb-7 ">
                    <a href="{{ route('contact.index') }}"
                        class="{{ request()->routeIs('contact.*') ? 'active' : '' }}">
                        <div class="tp-sidebar-menu-left d-flex align-items-center">
                            <i class="tp-sidebar-others-icon r-0 fas fa-life-ring"></i>
                            <span class="tp-sidebar-menu-list-title ml-7">{{ __('Support Tickets') }}</span>
                        </div>
                    </a>
                </li>

                {{-- Sales Management --}}
                <li class="tp-dropdown__menu-item mb-7 {{ request()->routeIs('admin.offers.*') ? 'open' : '' }}">
                    <a href="#" class="tp-dropdown-toggle" data-toggle="dropdown">
                        <div class="tp-sidebar-menu-left d-flex align-items-center">
                            <i class="tp-sidebar-others-icon r-0 fas fa-handshake"></i>
                            <span class="tp-sidebar-menu-list-title ml-7">{{ __('Exchanges') }}</span>
                        </div>
                        <i class="far fa-angle-right dropdown-icon"></i>
                    </a>
                    {{-- Offers --}}
                    <ul class="tp-dropdown__menu">

                        <li class="{{ request()->routeIs('admin.offers.index') ? 'active' : '' }}">
                            <a href="{{ route('admin.offers.index') }}">
                                <div class="tp-sidebar-menu-left d-flex align-items-center">
                                    <img src="{{ asset('assets/img/sidebar/side-bar-02.svg') }}" alt="">
                                    <span class="tp-sidebar-menu-list-title ml-7">{{ __('All Offers') }}</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Appearance --}}
                <li
                    class="tp-dropdown__menu-item mb-7 {{ request()->routeIs('banners.*') || request()->routeIs('theme.*') || request()->routeIs('testimonials.*') || request()->routeIs('fast-selling.*') ? 'open' : '' }}">
                    <a href="#" class="tp-dropdown-toggle" data-toggle="dropdown">
                        <div class="tp-sidebar-menu-left d-flex align-items-center">
                            <i class="tp-sidebar-others-icon r-0 fas fa-paint-brush"></i>
                            <span class="tp-sidebar-menu-list-title ml-7">{{ __('Appearance') }}</span>
                        </div>
                        <i class="far fa-angle-right dropdown-icon"></i>
                    </a>
                    <ul class="tp-dropdown__menu">
                        <li class="{{ request()->routeIs('banners.*') ? 'active' : '' }}">
                            <a href="{{ route('banners.index') }}">
                                <div class="tp-sidebar-menu-left d-flex align-items-center">
                                    <img src="{{ asset('assets/img/sidebar/side-bar-04.svg') }}" alt="">
                                    <span class="tp-sidebar-menu-list-title ml-7">{{ __('Banners') }}</span>
                                </div>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('theme.*') ? 'active' : '' }}">
                            <a href="{{ route('theme.index') }}">
                                <div class="tp-sidebar-menu-left d-flex align-items-center">
                                    <img src="{{ asset('assets/img/sidebar/side-bar-05.svg') }}" alt="">
                                    <span class="tp-sidebar-menu-list-title ml-7">{{ __('Theme') }}</span>
                                </div>
                            </a>
                        </li>

                        <li class="{{ request()->routeIs('testimonials.*') ? 'active' : '' }}">
                            <a href="{{ route('testimonials.index') }}">
                                <div class="tp-sidebar-menu-left d-flex align-items-center">
                                    <img src="{{ asset('assets/img/sidebar/side-bar-07.svg') }}" alt="">
                                    <span class="tp-sidebar-menu-list-title ml-7">{{ __('Testimonials') }}</span>
                                </div>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('fast-selling.*') ? 'active' : '' }}">
                            <a href="{{ route('fast-selling.index') }}">
                                <div class="tp-sidebar-menu-left d-flex align-items-center">
                                    <img src="{{ asset('assets/img/sidebar/side-bar-07.svg') }}" alt="">
                                    <span class="tp-sidebar-menu-list-title ml-7">{{ __('Fast Sellings') }}</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Moderation --}}
                <li class="tp-dropdown__menu-item mb-7 {{ request()->routeIs('reports.*') || request()->routeIs('admin.offers.*') ? 'open' : '' }}">
                    <a href="#" class="tp-dropdown-toggle" data-toggle="dropdown">
                        <div class="tp-sidebar-menu-left d-flex align-items-center">
                            <i class="tp-sidebar-others-icon r-0 fas fa-gavel"></i>
                            <span class="tp-sidebar-menu-list-title ml-7">{{ __('Moderation') }}</span>
                        </div>
                        <i class="far fa-angle-right dropdown-icon"></i>
                    </a>
                    <ul class="tp-dropdown__menu">
                        <li class="{{ request()->routeIs('admin.offers.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.offers.index') }}">
                                <div class="tp-sidebar-menu-left d-flex align-items-center">
                                    <i class="fas fa-handshake mr-2 opacity-50"></i>
                                    <span class="tp-sidebar-menu-list-title ml-7">{{ __('Barter Offers') }}</span>
                                </div>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('reports.index') ? 'active' : '' }}">
                            <a href="{{ route('reports.index') }}">
                                <div class="tp-sidebar-menu-left d-flex align-items-center">
                                    <i class="fas fa-flag mr-2 opacity-50"></i>
                                    <span class="tp-sidebar-menu-list-title ml-7">{{ __('Reports') }}</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Legal Pages --}}
                <li class="tp-dropdown__menu-item mb-7 {{ request()->routeIs('pages.*') ? 'open' : '' }}">
                    <a href="#" class="tp-dropdown-toggle" data-toggle="dropdown">
                        <div class="tp-sidebar-menu-left d-flex align-items-center">
                            <i class="tp-sidebar-others-icon r-0 fas fa-regular fa-file"></i>
                            <span class="tp-sidebar-menu-list-title ml-7">{{ __('Legal Pages') }}</span>
                        </div>
                        <i class="far fa-angle-right dropdown-icon"></i>
                    </a>
                    <ul class="tp-dropdown__menu">

                        {{-- term and and condition  --}}
                        <li class="{{ request()->is('pages/show/terms-conditions') ? 'active' : '' }}">
                            <a href="{{ route('pages.show', 'terms-conditions') }}">
                                <div class="tp-sidebar-menu-left d-flex align-items-center">
                                    <img src="{{ asset('assets/img/sidebar/side-bar-06.svg') }}" alt="">
                                    <span
                                        class="tp-sidebar-menu-list-title ml-7">{{ __('Terms & Condition') }}</span>
                                </div>
                            </a>
                        </li>

                        {{-- Privecy and Policy  --}}
                        <li class="{{ request()->is('pages/show/privacy-policy') ? 'active' : '' }}">
                            <a href="{{ route('pages.show', 'privacy-policy') }}">
                                <div class="tp-sidebar-menu-left d-flex align-items-center">
                                    <img src="{{ asset('assets/img/sidebar/side-bar-06.svg') }}" alt="">
                                    <span class="tp-sidebar-menu-list-title ml-7">{{ __('Privecy & Policy') }}</span>
                                </div>
                            </a>
                        </li>

                        {{-- About-Us  --}}
                        <li class="{{ request()->is('pages/show/about') ? 'active' : '' }}">
                            <a href="{{ route('pages.show', 'about') }}">
                                <div class="tp-sidebar-menu-left d-flex align-items-center">
                                    <img src="{{ asset('assets/img/sidebar/side-bar-06.svg') }}" alt="">
                                    <span class="tp-sidebar-menu-list-title ml-7">{{ __('About Us') }}</span>
                                </div>
                            </a>
                        </li>

                        {{--  Contact-US  --}}
                        <li class="{{ request()->is('pages/show/contact-us') ? 'active' : '' }}">
                            <a href="{{ route('pages.show', 'contact-us') }}">
                                <div class="tp-sidebar-menu-left d-flex align-items-center">
                                    <img src="{{ asset('assets/img/sidebar/side-bar-06.svg') }}" alt="">
                                    <span class="tp-sidebar-menu-list-title ml-7">{{ __('Contact Us') }}</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>


                {{-- CMS  --}}
                <li
                    class="tp-dropdown__menu-item tp-dropdown__menu__item__settings mb-7 {{ request()->routeIs('cms-*') ? 'open' : '' }}">
                    <a href="#" class="tp-dropdown-toggle" data-toggle="dropdown">
                        <div class="tp-sidebar-menu-left d-flex align-items-center">
                            <i class="tp-sidebar-others-icon r-0 fas fa-info-circle footer-icon"></i>
                            <span class="tp-sidebar-menu-list-title ml-7">{{ __('CMS') }}</span>
                        </div>
                        <i class="far fa-angle-right dropdown-icon"></i>
                    </a>
                    <ul class="tp-dropdown__menu">
                        <li class="{{ request()->routeIs('cms-footer.*') ? 'active' : '' }}">
                            <a href="{{ route('cms-footer.index') }}">
                                <div class="tp-sidebar-menu-left d-flex align-items-center">
                                    <img src="{{ asset('assets/img/sidebar/side-bar-09.svg') }}" alt="">
                                    <span class="tp-sidebar-menu-list-title ml-7">{{ __('Footer') }}</span>
                                </div>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('cms-navigation.*') ? 'active' : '' }}">
                            <a href="{{ route('cms-navigation.index') }}">
                                <div class="tp-sidebar-menu-left d-flex align-items-center">
                                    <i class="fas fa-sitemap mr-2 opacity-50"></i>
                                    <span class="tp-sidebar-menu-list-title ml-7">{{ __('Navigation') }}</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Settings --}}
                <li
                    class="tp-dropdown__menu-item tp-dropdown__menu__item__settings mb-7 {{ request()->routeIs('general-settings.*') || request()->routeIs('business-settings.*') || request()->routeIs('roles.*') || request()->routeIs('languages.*') ? 'open' : '' }}">
                    <a href="#" class="tp-dropdown-toggle" data-toggle="dropdown">
                        <div class="tp-sidebar-menu-left d-flex align-items-center">
                            <i class="tp-sidebar-others-icon r-0 fas fa-cogs"></i>
                            <span class="tp-sidebar-menu-list-title ml-7">{{ __('Settings') }}</span>
                        </div>
                        <i class="far fa-angle-right dropdown-icon"></i>
                    </a>
                    <ul class="tp-dropdown__menu">
                        <li class="{{ request()->routeIs('general-settings.*') ? 'active' : '' }}">
                            <a href="{{ route('general-settings.index') }}">
                                <div class="tp-sidebar-menu-left d-flex align-items-center">
                                    <img src="{{ asset('assets/img/sidebar/side-bar-09.svg') }}" alt="">
                                    <span class="tp-sidebar-menu-list-title ml-7">{{ __('General Settings') }}</span>
                                </div>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('business-settings.*') ? 'active' : '' }}">
                            <a href="{{ route('business-settings.index') }}">
                                <div class="tp-sidebar-menu-left d-flex align-items-center">
                                    <img src="{{ asset('assets/img/sidebar/side-bar-10.svg') }}" alt="">
                                    <span
                                        class="tp-sidebar-menu-list-title ml-7">{{ __('Business Settings') }}</span>
                                </div>
                            </a>
                        </li>

                        <li class="{{ request()->routeIs('roles.*') ? 'active' : '' }}">
                            <a href="{{ route('roles.index') }}">
                                <div class="tp-sidebar-menu-left d-flex align-items-center">
                                    <img src="{{ asset('assets/img/sidebar/side-bar-11.svg') }}" alt="">
                                    <span
                                        class="tp-sidebar-menu-list-title ml-7">{{ __('Role & Permissions') }}</span>
                                </div>
                            </a>
                        </li>

                        <li class="{{ request()->routeIs('languages.*') ? 'active' : '' }}">
                            <a href="{{ route('languages.index') }}">
                                <div class="tp-sidebar-menu-left d-flex align-items-center">
                                    <img src="{{ asset('assets/img/sidebar/side-bar-12.svg') }}" alt="">
                                    <span class="tp-sidebar-menu-list-title ml-7">{{ __('Languages') }}</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</div>
