@extends('web.profile.profile-master')
@section('notification-content')
    <div class="rs-profile-head d-flex align-items-center justify-content-between mb-16">
        <div class="profile-side-bar d-xl-none">
            <img src="{{ asset('assets/frontend/img/icon/side-bar-icon.svg') }}" alt="">
        </div>
        <h2 class="rs-profile-title">
            {{ __('Notifications') }}
        </h2>
        <a href="{{ route('user.read-all-notifications') }}"
            class="rs-btn bg-light text-dark shadow-none text-xs">
            <i class="fas fa-check-double mr-1"></i> {{ __('Mark all as read') }}
        </a>
    </div>

    @if($notifications->isEmpty())
        <div class="rs-profile-body p-40 text-center text-muted">
            <div class="mb-4 opacity-20">
                <i class="fas fa-bell-slash text-6xl"></i>
            </div>
            <p class="font-bold uppercase tracking-widest text-xs">{{ __('No notifications yet') }}</p>
        </div>
    @endif


        @foreach ($notifications as $notification)
            <div class="notification-item rs-profile-body mb-3 cursor-pointer hover:shadow-md transition-all border-l-4 {{ $notification->is_read ? 'border-transparent' : 'border-green-600' }}"
                data-notification="{{ $notification->id }}" style="cursor: pointer;">
                <div class="p-4 d-flex align-items-center gap-4">
                    <div class="flex-shrink-0">
                        <img src="{{ $notification->notificationSender->profilePhotoPath ?? asset('media/demo-img.png') }}" 
                             class="w-12 h-12 rounded-full object-cover border-2 border-white shadow-sm">
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start">
                            <h4 class="text-sm font-bold {{ $notification->is_read ? 'text-gray-500' : 'text-gray-900' }} mb-1">
                                {{ $notification->subject }}
                            </h4>
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                                {{ $notification->created_at->diffForHumans() }}
                            </span>
                        </div>
                        <p class="text-xs {{ $notification->is_read ? 'text-gray-400' : 'text-gray-600' }} mb-0">
                            {{ $notification->body }}
                        </p>
                    </div>
                </div>
            </div>
        @endforeach

    {{ $notifications->links() }}
@endsection
@push('script')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const notifications = document.querySelectorAll('.notification-item');

    notifications.forEach(notification => {
        notification.addEventListener('click', function () {
            const notificationId = notification.getAttribute('data-notification');

            // Step 1: Instantly add read class
            notification.classList.remove("border-green-600");
            notification.classList.add("border-transparent");

            // Step 2: Database update aar redirect
            axios.post("{{ route('user.notification.read') }}", {
                notification_id: notificationId
            })
            .then(response => {
                window.location.href = response.data.redirect_url;
            })
            .catch(error => {
                console.error("Something went wrong", error);
            });
        });
    });
});
</script>


@endpush
