@extends('web.profile.profile-master')
@section('message-content')
    <div class="">
        <div class="rs-profile-head d-flex align-items-center justify-content-between br-8 p-16 mb-16"
            data-bg-color="#F6F7F9">
            <div class="profile-side-bar d-xl-none">
                <img src="{{ asset('assets/frontend/img/icon/side-bar-icon.svg') }}" alt="">
            </div>
            <h2 class="rs-profile-title">
                {{ __('Massage') }}
            </h2>
        </div>

        <div class="rs-chat-wrapper d-flex">
            <!-- LEFT USER LIST -->

            <div class="rs-chat-custom-col mr-16">
                <h3 class="rs-chat-user-list-title">
                    {{ __('User List') }}
                </h3>
                <div class="rs-chat-input-group p-relative mb-16">
                    <input type="text" class="rs-chat-input" placeholder="Search User">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                        fill="none">

                    </svg>
                </div>

                <!-- SCROLLABLE WRAPPER -->
                <div class="user-list-wrapper"
                    style="height:550px; overflow-y: auto; position: relative; scrollbar-width: none;">
                    <ul class="rs-chat-users" id="user-list">
                        @foreach ($users as $user)
                            <li class="{{ $user->is_online ? 'active' : '' }}" onclick="selectUser({{ $user->id }})"
                                data-conversation-id="{{ $user->conversationId }}" id="user-{{ $user->id }}">
                                <a href="javascript:void(0)">
                                    <div class="rs-chat-users-img">
                                        <img src="{{ $user->profilePhotoPath }}" alt="Profile Photo">
                                    </div>
                                    <span class="rs-chat-user-name">
                                        {{ $user->name }}
                                        <cite class="rs-chat-user-massage {{ $user->hasUnread ? 'unread' : '' }}">
                                            {{ $user->lastMessageWithAuth?->contact ?? __('No messages yet') }}
                                        </cite>
                                    </span>
                                    <i class="rs-chat-user-active" id="status-{{ $user->id }}"
                                        style="color: {{ $user->is_online ? 'green' : 'gray' }}">
                                        {{ $user->is_online ? 'Online' : 'Offline' }}
                                    </i>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <div id="user-loader" class="text-center py-3" style="display:none;">
                        <span class="spinner-border spinner-border-sm"></span> {{ __('Loading more users') }}...
                    </div>
                </div>
            </div>

            <!-- RIGHT CHAT AREA -->
            <div class="rs-massage-right-area p-relative">
                {{-- upper (user) placeholder --}}
                <ul id="selected-user-info" class="text-center text-muted mb-16">
                    <li></li>
                </ul>

                <div class="rs-massage-medal p-16 pt-0" style="height:487px;">
                    {{-- attach product --}}
                    {{-- <div id="product-box" class="mb-16"></div> --}}

                    {{-- message box --}}
                    <div class="rs-massage-area mt-8" id="chat-box">
                        <p class="text-center text-muted select-author">{{ __('Select a user to start chatting') }}</p>
                    </div>
                </div>

                <!-- MESSAGE INPUT -->
                <div class="sand-message mt-16 p-relative"id="message-input-section" style="display:none;">
                    <div id="filePreview" class="mb-2 text-center" style="display:none;">
                        <img id="previewImg" src="" alt="Preview"
                            style="max-width:150px; border-radius:8px; box-shadow:0 0 6px rgba(0,0,0,0.1);">
                        <button type="button" id="removePreview" style="display:block; margin:8px auto;"
                            class="btn btn-sm btn-danger">
                            {{ __('Remove') }}
                        </button>
                    </div>
                    <form action="#" class="d-flex align-items-center gap-16 p-relative" id="chatForm">
                        <input type="file" id="fileInput" name="chatFile" hidden>
                        <a href="javascript:void(0)" class="file-btn" id="fileBtn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="20" viewBox="0 0 18 20"
                                fill="none">
                                <path
                                    d="M7.30599 19.749C5.39599 19.749 3.61698 19.02 2.29598 17.696C-0.490022 14.902 -0.446831 10.313 2.39217 7.46698L8.1202 1.72299C9.0672 0.772992 10.328 0.25 11.668 0.25C13.008 0.25 14.2691 0.772992 15.2161 1.72299C17.1701 3.68299 17.1701 6.872 15.2161 8.832L9.46004 14.603C8.37204 15.695 6.47318 15.696 5.38118 14.603C4.25818 13.477 4.25818 11.645 5.38118 10.519L10.4371 5.44901C10.7301 5.156 11.2051 5.155 11.4981 5.448C11.7921 5.74 11.7921 6.215 11.5001 6.509L6.44417 11.579C5.90317 12.121 5.90317 13.003 6.44417 13.545C6.96517 14.069 7.87703 14.068 8.39803 13.545L14.1541 7.77399C15.5261 6.39799 15.5261 4.15899 14.1541 2.78299C12.8261 1.45099 10.5112 1.45099 9.18319 2.78299L3.45516 8.52701C1.23616 10.751 1.19297 14.466 3.35897 16.638C4.39597 17.678 5.79699 18.25 7.30599 18.25C8.85299 18.25 10.36 17.628 11.442 16.543L16.4691 11.501C16.7611 11.208 17.2361 11.207 17.5301 11.5C17.8241 11.792 17.8241 12.267 17.5321 12.561L12.505 17.603C11.143 18.966 9.24799 19.749 7.30599 19.749Z"
                                    fill="#687387" />
                            </svg>
                        </a>
                        <input type="text" id="message" name="message" placeholder="Type a message">
                        <button type="submit" class="sand-message-btn p-absolute">
                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="18" viewBox="0 0 17 18"
                                fill="none">
                                <path
                                    d="M16.0201 7.27297L4.597 0.440973C1.876 -1.18703 -1.19685 1.93795 0.476149 4.63195L2.63508 8.10797C2.69008 8.19597 2.78597 8.24996 2.88997 8.24996H9.00105C9.41105 8.24996 9.75105 8.58996 9.75105 8.99996C9.75105 9.40996 9.41105 9.74996 9.00105 9.74996H2.88899C2.78499 9.74996 2.68911 9.80396 2.63411 9.89196L0.475172 13.368C-1.19783 16.062 1.87502 19.187 4.59602 17.559L16.0191 10.727C17.3261 9.94595 17.3261 8.05397 16.0201 7.27297Z"
                                    fill="#DD5454" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="{{ asset('assets/frontend/js/jquery-3.7.1.min.js') }}"></script>


    <script>
        let currencySymbol = "{{ $currency->symbol ?? '$' }}";
        let currencyPosition = "{{ $currency->position ?? 'left' }}";

        function currencyFormat(amount) {
            if (currencyPosition === 'left') {
                return currencySymbol + amount;
            } else {
                return amount + currencySymbol;
            }
        }

        // 1. Data that Blade already rendered
        let authUserId = {{ Auth::id() }};
        let convUserMap = @json($users->pluck('id', 'conversationId')->toArray());
        let allConvIds = @json($users->pluck('conversationId')->toArray());
        let selectedUserId = null;
        let currentConversationId = null;
        let pusher;
        let messagePage = 1;
        let messageHasMore = true;
        let messageLoading = false;
        const productShowUrl = "{{ route('product-details', ':id') }}";



        window.selectUser = function(userId) {
            selectedUserId = userId;
            const $li = $(`#user-${userId}`);
            currentConversationId = $li.data('conversation-id');

            $('.rs-chat-users li').removeClass('selected active');
            $li.addClass('selected active');

            // Load chat info
            loadSelectedUser(userId);
            loadMessages(userId);
            markRead(userId);

            // Show the message input section
            $('#message-input-section').slideDown(300);
        };




        function initPusher() {
            pusher = new Pusher("{{ config('broadcasting.connections.pusher.key') }}", {
                cluster: "{{ config('broadcasting.connections.pusher.options.cluster') }}",
                forceTLS: false,
                authEndpoint: "/broadcasting/auth",
                auth: {
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }
            });
            setupChannels();
        }

        const subscribedChannels = new Set();

        function setupChannels() {
            // ---- USER STATUS CHANNEL ----
            if (!subscribedChannels.has('status')) {
                const statusChannel = pusher.subscribe('private-user-status');
                statusChannel.bind('user.status.changed', function(data) {
                    const el = document.getElementById(`status-${data.userId}`);
                    if (!el) return;
                    el.textContent = data.isOnline ? 'Online' : 'Offline';
                    el.style.color = data.isOnline ? 'green' : 'gray';
                    $(`#user-${data.userId}`).toggleClass('active', data.isOnline);
                });
                subscribedChannels.add('status');
            }

            // ---- CONVERSATION CHANNELS ----
            allConvIds.forEach(cid => {
                const channelName = `private-chat.${cid}`;
                if (subscribedChannels.has(channelName)) return;

                const channel = pusher.subscribe(channelName);

                channel.bind('conversation_sent', data => {
                    if (!data?.message) return;

                    const msg = data.message;


                    if (msg.sender_id == authUserId) return;

                    const userId = convUserMap[msg.conversation_id];
                    if (!userId) return;

                    // ===== CASE 1: currently open chat =====
                    if (selectedUserId == userId) {
                        appendMessage(msg);
                        markRead(userId);
                    }
                    // ===== CASE 2: chat closed =====
                    else {
                        const $li = $(`#user-${userId}`);
                        if ($li.length) {
                            $li.find('.rs-chat-user-massage')
                                .text(msg.contact)
                                .addClass('unread');

                            $('.rs-chat-users').prepend($li);
                        }
                    }
                });

                subscribedChannels.add(channelName);
            });

        }

        // 4. USER HEADER
        function loadSelectedUser(userId) {
            $.get("{{ route('chat.user.details') }}", {
                    id: userId
                })
                .done(res => {
                    const last = res.lastMessageTime ?
                        `<i style="color:#687387;">${res.lastMessageTime}</i>` : '';
                    $('#selected-user-info').html(`
                            <ul><li class="rs-massage-id">
                                <a href="javascript:void(0)" class="d-flex align-items-center">
                                    <div class="rs-chat-users-img"><img src="${res.profilePhotoPath}" alt=""></div>
                                    <span class="rs-chat-user-name rs-chat-user-name-2 fns-18">
                                        ${res.name}
                                        <i class="rs-chat-user-active d-block text-start" style="color:${res.is_online?'green':'gray'}">
                                            ${res.is_online?'Online':'Offline'}
                                        </i>
                                        ${last}
                                    </span>
                                </a>
                            </li></ul>
                        `);
                });
        }


        function loadMessages(userId, page = 1, append = false) {
            if (messageLoading) return;
            messageLoading = true;
            selectedUserId = userId;

            $.get(`/fetch-messages/${userId}?page=${page}`).done(res => {


                let html = '';
                let productHtml = '';

                // === 1. Extract Product from ANY message (not just last) ===
                let product = null;
                if (res.messages && res.messages.length > 0) {
                    for (let i = res.messages.length - 1; i >= 0; i--) {
                        if (res.messages[i].product) {
                            product = res.messages[i].product;
                            break;
                        }
                    }
                }

                // === 2. Render Product Box (only once, on first load) ===
                if (!append && product) {
                    const url = productShowUrl.replace(':id', product.id);

                    productHtml = `
                     <div
                        class="rs-product-box rs-product-box-2 rs-product-box-3 rs-product-box-message d-flex align-items-center gap-16 h-152 mr-35 mb-16 mr-0 mb-16"
                        style="cursor:pointer"
                        onclick="window.location.href='${url}'">

                  <div class="rs-product-box rs-product-box-2 rs-product-box-3 rs-product-box-message d-flex align-items-center gap-16 h-152 mr-35 mb-16 mr-0 mb-0">
                    <div class="rs-product-thumb p-relative h-100">
                        <a class="popup-image h-100 d-block" href="${product.thumbnail}">
                            <img class="br-img-2-side h-100 object-fit-cover w-176" src="${product.thumbnail}" alt="${product.name}">
                        </a>
                    </div>
                    <div class="rs-product-content rs-product-content-2 pl-0">
                        <div class="rs-product-location">
                            <a href="javascript:void(0)" class="mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16" viewBox="0 0 14 16" fill="none">
                                    <path d="M7 0.6875C3.38125 0.6875 0.4375 3.63125 0.4375 7.25C0.4375 11.0885 3.96024 13.415 6.29124 14.9547L6.688 15.218C6.7825 15.281 6.89125 15.3125 7 15.3125C7.10875 15.3125 7.2175 15.281 7.312 15.218L7.70876 14.9547C10.0398 13.415 13.5625 11.0885 13.5625 7.25C13.5625 3.63125 10.6187 0.6875 7 0.6875Z" fill="#358CEF" />
                                </svg>
                                <span>${product.location}</span>
                            </a>
                        </div>
                        <a href="javascript:void(0)">
                            <h3 class="rs-product-title rs-product-title-2 mb-6">
                                ${product.name.length > 40
                                    ? product.name.substring(0, 40) + '...'
                                    : product.name}
                            </h3>
                        </a>
                        <a href="javascript:void(0)" class="rs-product-condition d-flex align-items-center mb-8">
                            Condition: &nbsp;
                            <span class="rs-product-border">${product.conditions}</span>

                        </a>
                        <div class="rs-product-price rs-product-price-2 d-flex align-items-center justify-content-between">
                            <b>${currencyFormat(product.asking_price)}</b>
                        </div>
                    </div>
                  </div>`;
                }

                // === 3. Render Messages ===
                if (!res.messages?.length) {
                    if (!append) {
                        html = '<p class="text-center text-muted">No messages yet</p>';
                    }
                } else {
                    res.messages.forEach((msg, i) => {
                        const isLast = i === res.messages.length - 1;
                        const time = msg.created_at ?
                            new Date(msg.created_at).toLocaleTimeString([], {
                                hour: '2-digit',
                                minute: '2-digit'
                            }) :
                            '';
                        const img = msg.profile_img ?? 'assets/img/massage/author-05.png';
                        const onclick = !isLast ? 'onclick="toggleTime(this)"' : '';

                        // Media (Image)
                        const mediaHtml = msg.media ?
                            `<div class="chat-image">
                           <img src="${msg.media}"
                            style="width:150px; height:150px !important; object-fit:cover; border-radius:8px; cursor:pointer;"
                            onclick="window.open(this.src, '_blank')">
                       </div>` :
                            '';

                        // Message Bubble
                        if (msg.receiver_id == authUserId) {
                            // Incoming message (left side)
                            html += `
                        <div class="message-my mb-24 mt-24 message-item">
                            <div class="d-flex align-items-end mb-10" ${onclick}>
                                <img src="${img}" alt="">
                                <div class="my-message">
                                    ${msg.contact || ''}${mediaHtml}
                                </div>
                            </div>
                            <span class="message-time" style="display:${isLast ? 'block' : 'none'}">${time}</span>
                        </div>`;
                        } else {
                            // Outgoing message (right side)
                            html += `
                        <div class="message-your message-item">
                            <div class="d-flex justify-content-end align-items-end mb-2" ${onclick}>
                                <div class="your-massage">
                                    ${msg.contact || ''}${mediaHtml}
                                </div>
                                <img src="${img}" alt="">
                            </div>
                            <span class="message-time" style="display:${isLast ? 'block' : 'none'}">${time}</span>
                        </div>`;
                        }
                    });
                }

                // === 4. Update DOM ===
                if (!append) {
                    let finalHtml = '';

                    // product box message area'r vitore (top e)
                    if (productHtml) {
                        finalHtml += `
            <div class="chat-product-wrapper mb-24">
                ${productHtml}
            </div>
        `;
                    }

                    finalHtml += html;

                    $('#chat-box').html(finalHtml);
                    $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);
                }


                // === 5. Pagination ===
                messagePage = page;
                messageHasMore = res.next_page;

            }).always(() => {
                messageLoading = false;
            });
        }

        // Infinite Scroll for Chat Box
        $('#chat-box').on('scroll', function() {
            if ($(this).scrollTop() < 50 && messageHasMore && !messageLoading) {
                loadMessages(selectedUserId, messagePage + 1, true);
            }
        });


        function appendMessage(msg) {
            const chat = document.getElementById('chat-box');
            const time = msg.created_at ?
                new Date(msg.created_at).toLocaleTimeString([], {
                    hour: '2-digit',
                    minute: '2-digit'
                }) :
                '';

            const img = msg.profile_img ?? 'assets/img/massage/author-05.png'; // <-- safe
            const mediaHtml = msg.media ?
                `<div class="chat-image">
            <img src="${msg.media}"  style="width:150px; height:150px !important; object-fit:cover; border-radius:8px; cursor:pointer;"
                 onclick="window.open(this.src,'_blank')">
            </div>` :
                '';

            let html = '';

            if (msg.sender_id == authUserId) {
                // RIGHT → my message
                html += `
            <div class="message-your message-item">
                <div class="d-flex justify-content-end align-items-end mb-2">
                    <div class="your-massage">
                        ${msg.contact || ''}${mediaHtml}
                    </div>
                    <img src="${img}" alt="">
                </div>
                <span class="message-time">${time}</span>
            </div>`;
            } else {
                // LEFT → incoming
                html += `
            <div class="message-my mb-24 mt-24 message-item">
                <div class="d-flex align-items-end mb-10">
                    <img src="${img}" alt="">
                    <div class="my-message">
                        ${msg.contact || ''}${mediaHtml}
                    </div>
                </div>
                <span class="message-time">${time}</span>
            </div>`;
            }

            chat.insertAdjacentHTML('beforeend', html);
            chat.scrollTop = chat.scrollHeight;
        }

        // 7. MARK READ
        function markRead(userId) {
            $.post(`/mark-read/${userId}`, {
                    _token: '{{ csrf_token() }}'
                })
                .done(() => $(`#user-${userId} .rs-chat-user-massage`).removeClass('unread'));
        }

        // 8. SEND MESSAGE
        $('#chatForm').on('submit', function(e) {
            e.preventDefault();
            if (!selectedUserId) return;

            let text = $('#message').val().trim();
            let fileInput = $('#fileInput')[0];
            let file = fileInput.files[0];

            if (!text && !file) return;

            // ===== 1. DUMMY MESSAGE =====
            const dummyMsg = {
                sender_id: authUserId,
                receiver_id: selectedUserId,
                contact: text,
                created_at: new Date().toISOString(),
                media: file ? URL.createObjectURL(file) : null,
                profile_img: '{{ Auth::user()->profilePhotoPath ?? 'assets/img/massage/author-05.png' }}'
            };

            appendMessage(dummyMsg);

            // ===== 2. SEND TO SERVER =====
            const formData = new FormData();
            formData.append('receiver_id', selectedUserId);
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('message', text);
            if (file) formData.append('chatFile', file);

            // Clear inputs
            $('#message').val('');

            // Reset file input safely
            const $fileInput = $('#fileInput');
            $fileInput.replaceWith($fileInput.val('').clone(true));

            // Hide preview and reset image
            $('#filePreview').hide();
            $('#previewImg').attr('src', '');

            $.ajax({
                url: '{{ route('send.message') }}',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
            });
        });


        // 9. TOGGLE TIME
        window.toggleTime = function(el) {
            $(el).closest('.message-item').find('.message-time').toggle();
        };
        // };

        $(window).on('load', function() {
            setTimeout(() => {
                initPusher();
                Pusher.logToConsole = true
            }, 800);

            setInterval(() => {
                $.post('{{ route('keep.alive') }}', {
                    _token: '{{ csrf_token() }}'
                }).done(() => {
                    console.log('Online status updated');
                });
            }, 600000);
        });

        // File button click
        $('#fileBtn').on('click', function() {
            $('#fileInput').click();
        });

        //  Image Preview (above message box)
        $('#fileInput').on('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#previewImg').attr('src', e.target.result);
                    $('#filePreview').show();
                };
                reader.readAsDataURL(file);
            }
        });

        //  Remove Preview
        $('#removePreview').on('click', function() {
            $('#fileInput').val('');
            $('#filePreview').hide();
            $('#previewImg').attr('src', '');
        });


        // search
        $(document).ready(function() {
            const $searchInput = $('.rs-chat-input');
            const $userList = $('.rs-chat-users');
            const $users = $userList.find('li');

            $searchInput.on('input', function() {
                const search = $(this).val().toLowerCase();
                let found = false;

                $users.each(function() {
                    const userName = $(this).find('.rs-chat-user-name').text().toLowerCase();
                    if (userName.includes(search)) {
                        $(this).show();
                        found = true;
                    } else {
                        $(this).hide();
                    }
                });


                $userList.find('.no-users-found').remove();

                if (!found) {
                    $userList.append(
                        '<li class="no-users-found text-center text-muted">No users found</li>');
                }
            });
        });


        //    INFINITE SCROLL – USER LIST

        let userPage = 1;
        let userLoading = false;
        let userHasMore = true;

        function loadMoreUsers() {
            if (!userHasMore || userLoading) return;
            userLoading = true;
            $('#user-loader').show();

            $.get("{{ route('chat.users.paginated') }}", {
                    page: ++userPage
                })
                .done(res => {
                    if (!res.users?.length) {
                        userHasMore = false;
                        return;
                    }

                    const $ul = $('#user-list');
                    res.users.forEach(u => {
                        const li = `
                                <li class="${u.is_online ? 'active' : ''}"
                                    onclick="selectUser(${u.id})"
                                    data-conversation-id="${u.conversationId}"
                                    id="user-${u.id}">
                                    <a href="javascript:void(0)">
                                        <div class="rs-chat-users-img"><img src="${u.profilePhotoPath}" alt=""></div>
                                        <span class="rs-chat-user-name">
                                            ${u.name}
                                            <cite class="rs-chat-user-massage ${u.hasUnread ? 'unread' : ''}">
                                                ${u.lastMessageWithAuth?.message ?? 'No messages yet'}
                                            </cite>
                                        </span>
                                        <i class="rs-chat-user-active" id="status-${u.id}"
                                        style="color:${u.is_online?'green':'gray'}">
                                            ${u.is_online?'Online':'Offline'}
                                        </i>
                                    </a>
                                </li>`;
                        $ul.append(li);
                    });

                    userHasMore = !!res.next_page;
                })
                .always(() => {
                    userLoading = false;
                    $('#user-loader').hide();
                });
        }

        $('.user-list-wrapper').on('scroll', function() {
            const el = this;
            if (el.scrollTop + el.clientHeight >= el.scrollHeight - 100) {
                loadMoreUsers();
            }
        });
    </script>
@endpush

