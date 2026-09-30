@extends('web.layouts.master')
@section('content')
    <!-- profile offcanvas start -->
    @include('web.profile.sections.profile-offcanvas')
    <!-- profile offcanvas end -->

    <!-- Verified Modal -->
    @include('web.profile.sections.verified-modal')
    <!-- Verified Modal -->
    
    <!-- Report Seller Modal -->
    @include('web.profile.sections.report-modal')
    <!-- Report Seller Modal End -->


    <div id="smooth-wrapper">
        <div id="smooth-content">
            <main>



                <!-- profile area start -->
                <section class="rs-profile-area mt-20">
                    <div class="container">
                        <div class="row">
                            {{-- Sidebar  --}}
                            @include('web.profile.sections.sidebar')

                            {{-- My Profile  --}}
                            <div class="col-xl-9 col-lg-12">
                                @yield('profile-content')
                                @yield('user-change-password')
                                @yield('my-wallet')
                                @yield('my-ads-contnet')
                                @yield('wishlist-content')
                                @yield('message-content')
                                @yield('promot-content')
                                @yield('checkout-content')
                                @yield('sold-out-content')
                                @yield('notification-content')
                                @yield('payment-history-content')
                                @yield('review-content')
                                @yield('trash-content')
                            </div>
                        </div>
                    </div>
                </section>
                <!-- profile area end -->
            </main>
        </div>
    </div>
@endsection
