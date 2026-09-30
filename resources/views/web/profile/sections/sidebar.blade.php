<div class="col-xl-3 d-none d-xl-block">
    <div class="rs-profile-side-bar">
        <div class="rs-profile-side-bar-head d-flex align-items-center br-8" style="background: #f0fdf4; border: 1px solid #dcfce7;">
            <div class="rs-profile-side-bar-profile-img mr-12">
                <a href="javascript:void(0)" class="rs-profile-img-add rs-profile-img-add-2" style="border-color: #16a34a;">
                    <img class="br-100" src="{{ auth()->user()->profilePhotoPath ?? 'https://placehold.co/600x400' }}"
                        alt="Profile Photo" style="border: 2px solid #16a34a;">
                </a>
            </div>
            <div class="rs-profile-user-info mr-6 d-flex flex-column">
                <a href="javascript:void(0)" class="rs-profile-user-name" style="color: #16a34a; font-weight: 700;">
                    {{ auth()->user()->name ?? '' }}
                </a>
                <a href="mailto:{{ auth()->user()->email }}" class="rs-profile-user-email">
                    {{ Str::limit(auth()->user()->email, 20) }}
                </a>
            </div>
            @if (auth()->user()?->email_verified_at || auth()->user()?->phone_verified_at)
                <div class="rs-profile-user-icon">
                    <i class="fas fa-check-circle" style="color: #16a34a;"></i>
                </div>
            @endif
        </div>
        <div class="rs-profile-side-bar-body p-16 pt-8">
            <div class="rs-profile-side-bar-list">
                <ul class="nav flex-column">
                    <li class="nav-item mb-2 {{ request()->routeIs('user.profile') ? 'active' : '' }}">
                        <a href="{{ route('user.profile') }}" class="d-flex align-items-center gap-15 py-2 px-3 rounded-pill {{ request()->routeIs('user.profile') ? 'bg-success text-white' : 'text-dark' }}">
                            <i class="fas fa-user-circle"></i>
                            {{ __('My Profile') }}
                        </a>
                    </li>

                    <li class="nav-item mb-2 {{ request()->routeIs('user.offers') ? 'active' : '' }}">
                        <a href="{{ route('user.offers') }}" class="d-flex align-items-center gap-15 py-2 px-3 rounded-pill {{ request()->routeIs('user.offers') ? 'bg-success text-white' : 'text-dark' }}">
                            <i class="fas fa-handshake"></i>
                            {{ __('My Barter Offers') }}
                            <span class="badge bg-warning text-dark ms-auto" style="font-size: 10px;">{{ __('SPA') }}</span>
                        </a>
                    </li>

                    <li class="nav-item mb-2 {{ request()->routeIs(['user.my-ads', 'user.soldout']) ? 'active' : '' }}">
                        <a href="{{ route('user.my-ads') }}" class="d-flex align-items-center gap-15 py-2 px-3 rounded-pill {{ request()->routeIs(['user.my-ads', 'user.soldout']) ? 'bg-success text-white' : 'text-dark' }}">
                            <i class="fas fa-bullhorn"></i>
                            {{ __('My Barter Ads') }}
                        </a>
                    </li>

                    <li class="nav-item mb-2 {{ request()->routeIs('user.show-notifications') ? 'active' : '' }}">
                        <a href="{{ route('user.show-notifications') }}" class="d-flex align-items-center gap-15 py-2 px-3 rounded-pill {{ request()->routeIs('user.show-notifications') ? 'bg-success text-white' : 'text-dark' }}">
                            <i class="fas fa-bell"></i>
                            {{ __('Notifications') }}
                            <cite class="ms-auto badge bg-danger rounded-pill">{{ getUnreadNotificationsCount(true) }}</cite>
                        </a>
                    </li>

                    <li class="nav-item mb-2 {{ request()->routeIs('chat.index') ? 'active' : '' }}">
                        <a href="{{ route('chat.index') }}" class="d-flex align-items-center gap-15 py-2 px-3 rounded-pill {{ request()->routeIs('chat.index') ? 'bg-success text-white' : 'text-dark' }}">
                            <i class="fas fa-comment-dots"></i>
                            {{ __('Messages') }}
                            <cite class="ms-auto badge bg-primary rounded-pill">{{ unreadUserCount() }}</cite>
                        </a>
                    </li>

                    <li class="nav-item mb-2 {{ request()->routeIs('user.show-wishlist', 'wishlist.index') ? 'active' : '' }}">
                        <a href="{{ route('user.show-wishlist') }}" class="d-flex align-items-center gap-15 py-2 px-3 rounded-pill {{ request()->routeIs('user.show-wishlist', 'wishlist.index') ? 'bg-success text-white' : 'text-dark' }}">
                            <i class="fas fa-heart"></i>
                            {{ __('Wishlist') }}
                        </a>
                    </li>

                    <li class="nav-item mb-2 {{ request()->routeIs('user.review-index') ? 'active' : '' }}">
                        <a href="{{ route('user.review-index') }}" class="d-flex align-items-center gap-15 py-2 px-3 rounded-pill {{ request()->routeIs('user.review-index') ? 'bg-success text-white' : 'text-dark' }}">
                            <i class="fas fa-star"></i>
                            {{ __('Reviews') }}
                        </a>
                    </li>

                    <hr class="my-3 opacity-10">

                    <li class="nav-item mb-2 {{ request()->routeIs('user.change-password-index') ? 'active' : '' }}">
                        <a href="{{ route('user.change-password-index') }}" class="d-flex align-items-center gap-15 py-2 px-3 rounded-pill text-dark">
                            <i class="fas fa-key"></i>
                            {{ __('Security') }}
                        </a>
                    </li>

                    <li class="nav-item">
                        <form id="logoutForm" action="{{ route('user.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="d-flex align-items-center gap-15 py-2 px-3 rounded-pill text-danger border-0 bg-transparent w-100 logoutCon">
                                <i class="fas fa-sign-out-alt"></i>
                                {{ __('Logout') }}
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<style>
    .rs-profile-side-bar-list .nav-item a:hover {
        background-color: #f0fdf4;
        color: #16a34a !important;
    }
    .rs-profile-side-bar-list .active a {
        background-color: #16a34a !important;
        color: white !important;
    }
</style>


<script>
    document.querySelector('.logoutCon').addEventListener('click', e => {
        e.preventDefault();
        Swal.fire({
            title: 'Are you sure?',
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, logout!',
        }).then(result => {
            if (result.isConfirmed) {
                document.querySelector('#logoutForm').submit();
            }
        });
    });
</script>
