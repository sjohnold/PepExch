<div class="container-fluids">
    <div id="tp-header-sticky" class="tp-ride-header-area p-relative z-1 header-sticky" data-bg-color="#fff">
        <div class="row align-items-center ">
            <div class="col-xl-2 col-lg-1 col-md-1 col-4">
                <div class="tp-header-left">
                    <div class="tp-header-menu-icon">
                        <a id="sidebar__active" href="javascript:void(0)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="15" viewBox="0 0 20 15"
                                fill="currentColor">
                                <path
                                    d="M0.25 1.5C0.25 1.086 0.586 0.75 1 0.75H19C19.414 0.75 19.75 1.086 19.75 1.5C19.75 1.914 19.414 2.25 19 2.25H1C0.586 2.25 0.25 1.914 0.25 1.5ZM19 6.75H1C0.586 6.75 0.25 7.086 0.25 7.5C0.25 7.914 0.586 8.25 1 8.25H19C19.414 8.25 19.75 7.914 19.75 7.5C19.75 7.086 19.414 6.75 19 6.75ZM19 12.75H1C0.586 12.75 0.25 13.086 0.25 13.5C0.25 13.914 0.586 14.25 1 14.25H19C19.414 14.25 19.75 13.914 19.75 13.5C19.75 13.086 19.414 12.75 19 12.75Z"
                                    fill="currentColor" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-xl-10 col-lg-11 col-md-11 col-8">
                <div class="tp-header-right d-flex align-items-center justify-content-end">
                    <div class="tp-header-switch mr-8">
                        <a href="#" id="darkModeToggle">
                            <!-- Light Mode Icon -->
                            <img class="tp-header-switch-icon sun-icon"
                                src="{{ asset('assets/img/icon/switch-icon.png') }}" alt="Light">
                            <span class="tp-header-icon-title">{{ __('Light') }}</span>
                            <!-- Dark Mode Icon -->
                            <img class="tp-header-switch-icon moon-icon"
                                src="{{ asset('assets/img/icon/switch-icon-02.png') }}" alt="Dark">
                        </a>
                    </div>

                    <div class="tp-header-notification mr-8 d-none d-md-block">
                        <a href="javascript:void(0)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 19 19"
                                fill="currentColor">
                                <path opacity="0.4"
                                    d="M15.7932 13.766C15.779 13.7488 14.3712 11.9615 14.3712 9.875V7.24625C14.3712 4.5605 12.1857 2.375 9.49997 2.375C6.81422 2.375 4.62872 4.5605 4.62872 7.24625V9.875C4.62872 11.9607 3.22173 13.748 3.20673 13.766C3.11673 13.8785 3.09948 14.033 3.16173 14.1627C3.22398 14.2925 3.35522 14.375 3.49922 14.375H15.4992C15.6432 14.375 15.7745 14.2925 15.8367 14.1627C15.9005 14.0322 15.8825 13.8785 15.7932 13.766Z"
                                    fill="currentColor" />
                                <path
                                    d="M2.75081 7.0625C2.73206 7.0625 2.7133 7.06175 2.6938 7.0595C2.3848 7.02875 2.15906 6.75275 2.19056 6.44375C2.34206 4.9265 2.95557 3.52026 3.96357 2.37726C4.16832 2.14401 4.52456 2.1215 4.75781 2.32775C4.99106 2.53325 5.01282 2.88875 4.80732 3.122C3.95607 4.0865 3.43781 5.27375 3.30956 6.5555C3.28106 6.84575 3.03581 7.0625 2.75081 7.0625Z"
                                    fill="currentColor" />
                                <path
                                    d="M16.2492 7.0625C15.9642 7.0625 15.719 6.84575 15.6905 6.55625C15.5622 5.2745 15.0447 4.08725 14.1927 3.12275C13.9872 2.8895 14.0097 2.534 14.2422 2.3285C14.4755 2.12225 14.831 2.1455 15.0365 2.378C16.0445 3.52025 16.658 4.9265 16.8095 6.4445C16.841 6.7535 16.6152 7.0295 16.3062 7.06025C16.2867 7.06175 16.268 7.0625 16.2492 7.0625Z"
                                    fill="currentColor" />
                                <path
                                    d="M11.123 15.3133C11.0563 15.197 10.9325 15.125 10.7975 15.125H8.20252C8.06827 15.125 7.94452 15.197 7.87702 15.3133C7.80952 15.4295 7.81104 15.5735 7.87854 15.689C8.22054 16.2747 8.82653 16.625 9.50003 16.625C10.1735 16.625 10.7795 16.2747 11.1215 15.689C11.189 15.5735 11.1898 15.4295 11.123 15.3133Z"
                                    fill="currentColor" />
                            </svg>
                            <span class="tp-header-icon-title">
                                {{ __('Notification') }}
                            </span>
                            <cite>
                                {{ getUnreadNotificationsCount() }}
                            </cite>
                        </a>

                        <div class="tp-header-notification-show p-absolute">
                            <div
                                class="tp-header-notification-top d-flex align-items-center justify-content-between pb-8">
                                <h3 class="tp-header-notification-top-title">
                                    {{ __('Notifications') }}
                                </h3>
                                <a href="{{ route('admin.notification.read-all') }}">
                                    {{ __('Marks all as read') }}
                                </a>
                            </div>


                            <div class="tp-header-notification-area">
                                @foreach ($adminNotifiactions = getNotifications() as $adminNotifiaction)
                                    <div class="notification-item pl-10 br-8 {{ $adminNotifiaction->is_read ? 'tp-header-notification-show-item-read' : 'tp-header-notification-show-item-unread' }} d-flex pt-25 pb-25 p-relative"
                                        data-notification="{{ $adminNotifiaction->id }}">
                                        <div class="tp-header-notification-icon">
                                            <i class="far fa-bell"></i>
                                        </div>
                                        <div class="tp-header-notification-content">
                                            <h4 class="tp-header-notification-title">
                                                {{ $adminNotifiaction->subject }}
                                            </h4>
                                            <p>
                                                {{ $adminNotifiaction->body }}
                                            </p>
                                        </div>
                                        <div class="tp-header-notification-date">
                                            <span>{{ $adminNotifiaction->created_at->format('jS F Y') }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>


                            <div class="tp-header-notification-bottom">
                            </div>
                        </div>
                    </div>


                    <div class="dropdown tp-header-lang d-none d-md-block me-3">
                        @php
                            $currentLang =
                                $languages->where('status', 1)->firstWhere('name', session('locale')) ??
                                $languages->where('status', 1)->firstWhere('name', 'en');

                            $currentImg =
                                $currentLang && $currentLang->thumbnail
                                    ? asset('storage/' . $currentLang->thumbnail->src)
                                    : asset('assets/frontend/img/flag/en.jpg');
                        @endphp


                        {{-- Current Language Button --}}
                        <button class="btn btn-light d-flex align-items-center gap-2 dropdown-toggle" type="button"
                            id="languageDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ $currentImg }}" alt="{{ $currentLang->title ?? 'English' }}" width="20"
                                height="20" style="object-fit: cover; border-radius: 3px;">
                            <span>{{ $currentLang->title ?? 'English' }}</span>
                        </button>

                        {{-- Dropdown Menu --}}
                        <ul class="dropdown-menu shadow" aria-labelledby="languageDropdown">
                            @foreach ($languages->where('status', 1) as $language)
                                <li>
                                    <a href="{{ route('change.language', ['language' => $language->name]) }}"
                                        class="d-inline">
                                        <button type="button"
                                            class="dropdown-item d-flex align-items-center gap-2 {{ $currentLang && $currentLang->name === $language->name ? 'active' : '' }}">
                                            <img src="{{ $language->thumbnail
                                                ? asset('storage/' . $language->thumbnail->src)
                                                : asset('assets/frontend/img/flag/default-flag.png') }}"
                                                alt="{{ $language->title }}" width="20" height="20"
                                                style="object-fit: cover; border-radius: 3px;">
                                            <span>{{ $language->title }}</span>
                                        </button>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>


                    <div class="tp-header-author d-flex align-items-center p-relative">
                        <div class="tp-header-author-content mr-12 text-end">
                            <a href="#" class="tp-header-author-name">
                                {{ auth()->user()->name ?? null }} <br>
                            </a>
                            <span>
                                {{ optional(auth()->user()?->getRoleNames())->first() ?? '' }}
                            </span>
                        </div>

                        <div class="tp-header-author-thumb">
                            <a href="#">
                                <img src="{{ auth()->user()->profilePhotoPath ?? '' }}" alt=""
                                    style="border-radius: 50%; width: 45px; height: 45px; object-fit: cover; margin-left:2px">
                            </a>
                        </div>

                        <div class="tp-header-author-thumb-more p-absolute"
                            style="background: #ffffff; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); min-width: 250px;">

                            {{-- <a href="#"
                                style="padding: 14px 25px; display: flex; align-items: center; color: #333; text-decoration: none; font-size: 15px; margin-bottom:5px"
                                onmouseover="this.style.background='#e8e8e8'"
                                onmouseout="this.style.background='transparent'">
                                <i class="fal fa-user-circle" style="margin-right: 12px; width: 18px;"></i>
                                {{ __('Profile') }}
                            </a> --}}

                            <a href="{{ route('posts.index') }}"
                                style="padding: 14px 25px; display: flex; align-items: center; color: #333; text-decoration: none; font-size: 15px; margin-bottom:5px"
                                onmouseover="this.style.background='#e8e8e8'"
                                onmouseout="this.style.background='transparent'">
                                <i class="fal fa-plus-circle" style="margin-right: 12px; width: 18px;"></i>
                                {{ __('Product List') }}
                            </a>

                            <a href="{{ route('roles.index') }}"
                                style="padding: 14px 25px; display: flex; align-items: center; color: #333; text-decoration: none; font-size: 15px; margin-bottom:5px"
                                onmouseover="this.style.background='#e8e8e8'"
                                onmouseout="this.style.background='transparent'">
                                <i class="fal fa-user-shield" style="margin-right: 12px; width: 18px;"></i>
                                {{ __('Role & Permission') }}
                            </a>

                            <a href="{{ route('theme.index') }}"
                                style="padding: 14px 25px; display: flex; align-items: center; color: #333; text-decoration: none; font-size: 15px; margin-bottom:5px"
                                onmouseover="this.style.background='#e8e8e8'"
                                onmouseout="this.style.background='transparent'">
                                <i class="fal fa-palette" style="margin-right: 12px; width: 18px;"></i>
                                {{ __('Theme Color') }}
                            </a>

                            <a href="{{ route('general-settings.index') }}"
                                style="padding: 14px 25px; display: flex; align-items: center; color: #333; text-decoration: none; font-size: 15px;margin-bottom:10px"
                                onmouseover="this.style.background='#e8e8e8'"
                                onmouseout="this.style.background='transparent'">
                                <i class="fas fa-cog" style="margin-right: 12px; width: 18px;"></i>
                                {{ __('General Setting') }}
                            </a>

                            <form method="POST" action="{{ route('admin.logout') }}" id="logout-form"
                                style="display:none;">
                                @csrf
                            </form>

                            <a href="#"
                                style="padding: 0 26px; display: flex; align-items: center; color: #dc3545; text-decoration: none; font-size: 15px;"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                onmouseover="this.style.background='#ffe5e5'"
                                onmouseout="this.style.background='transparent'">
                                <i class="fal fa-sign-out" style="margin-right: 12px; width: 18px;"></i>
                                {{ __('Logout') }}
                            </a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- This Script is for read unread --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const notificationArea = document.querySelector('.tp-header-notification-area');

        if (notificationArea) {
            notificationArea.addEventListener('click', function(e) {
                const item = e.target.closest('.notification-item');
                if (!item) return;
                const notificationId = item.getAttribute('data-notification');
                if (!notificationId) return;
                item.classList.remove('tp-header-notification-show-item-unread');
                item.classList.add('tp-header-notification-show-item-read');
                axios.post("{{ route('admin.notification.read') }}", {
                        notification_id: notificationId
                    })
                    .then(() => {
                        console.log('Readed');
                        const badge = document.querySelector('.tp-header-notification cite');
                        if (badge) {
                            let count = parseInt(badge.textContent) || 0;
                            if (count > 0) badge.textContent = count - 1;
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        item.classList.remove('tp-header-notification-show-item-read');
                        item.classList.add('tp-header-notification-show-item-unread');
                    });
            });
        }
    });
</script>


{{-- This script is for load more again  --}}
<script>
    const notificationArea = document.querySelector('.tp-header-notification-area');
    let page = 1;
    let loading = false;
    let hasMorePages = true;
    const escapeHtml = (value) => String(value ?? '').replace(/[&<>"']/g, (char) => ({
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;',
    }[char]));

    if (notificationArea) {
        notificationArea.addEventListener('scroll', function() {
            // hasMorePages check
            if (notificationArea.scrollTop + notificationArea.clientHeight >= notificationArea.scrollHeight -
                50 &&
                !loading &&
                hasMorePages) {

                loading = true;
                page++;

                axios.get("{{ route('admin.notifications.load-more') }}?page=" + page)
                    .then(res => {
                        if (res.data.notifications && res.data.notifications.length > 0) {
                            res.data.notifications.forEach(n => {
                                const cls = n.is_read ? 'tp-header-notification-show-item-read' :
                                    'tp-header-notification-show-item-unread';

                                // Date formatting
                                const date = new Date(n.created_at);
                                const formattedDate = date.toLocaleDateString('en-GB', {
                                    day: 'numeric',
                                    month: 'long',
                                    year: 'numeric'
                                });

                                notificationArea.insertAdjacentHTML('beforeend', `
                                    <div class="notification-item pl-10 br-8 ${cls} d-flex pt-25 pb-25 p-relative" data-notification="${n.id}">
                                        <div class="tp-header-notification-icon">
                                            <i class="far fa-bell"></i>
                                        </div>
                                        <div class="tp-header-notification-content">
                                            <h4 class="tp-header-notification-title">${escapeHtml(n.subject)}</h4>
                                            <p>${escapeHtml(n.body)}</p>
                                        </div>
                                        <div class="tp-header-notification-date">
                                            <span>${formattedDate}</span>
                                        </div>
                                    </div>
                                `);
                            });
                        }

                        // has_more check
                        hasMorePages = res.data.has_more || false;
                        loading = false;
                    })
                    .catch(err => {
                        console.error('Error loading notifications:', err);
                        loading = false;
                        page--; //
                    });
            }
        });
    }
</script>
