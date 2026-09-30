@extends('layouts.app')

@section('content')
    <x-table-header :title="'Offer Details #' . $offer->id" :subtitle="'Full details of this barter exchange'" :icon="'fas fa-handshake'" />

    <div class="row g-4">
        {{-- Main Info --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <img src="{{ $offer->sellingPost->profilePath ?? '/assets/img/no-image.png' }}" class="rounded-3" style="width: 80px; height: 80px; object-fit: cover;">
                        <div>
                            <h5 class="fw-bold mb-1">{{ $offer->sellingPost->name ?? 'N/A' }}</h5>
                            <span class="badge {{ $offer->status === 'completed' ? 'bg-success' : ($offer->status === 'pending' ? 'bg-warning' : 'bg-secondary') }} rounded-pill">
                                {{ ucfirst($offer->status) }}
                            </span>
                        </div>
                    </div>

                    <hr>

                    <div class="row g-4">
                        {{-- Sender --}}
                        <div class="col-md-6">
                            <h6 class="fw-bold text-muted mb-3"><i class="fas fa-user text-primary me-2"></i>Sender (Initiator)</h6>
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <img src="{{ $offer->sender->profilePhotoPath ?? '' }}" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                                <div>
                                    <div class="fw-semibold">{{ $offer->sender->name ?? 'N/A' }}</div>
                                    <small class="text-muted">{{ $offer->sender->email ?? '' }}</small>
                                </div>
                            </div>
                            <p class="fw-semibold small mb-2">Items Offered:</p>
                            @if(is_array($offer->sender_items))
                                @foreach($offer->sender_items as $item)
                                    <span class="badge bg-success-subtle text-success rounded-pill px-2 me-1 mb-1">{{ $item }}</span>
                                @endforeach
                            @endif
                            <div class="mt-2">
                                <small class="text-muted">Confirmed: {{ $offer->sender_confirmed ? '✅ Yes' : '⏳ No' }}</small>
                            </div>
                        </div>

                        {{-- Receiver --}}
                        <div class="col-md-6">
                            <h6 class="fw-bold text-muted mb-3"><i class="fas fa-user text-info me-2"></i>Receiver (Post Owner)</h6>
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <img src="{{ $offer->receiver->profilePhotoPath ?? '' }}" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                                <div>
                                    <div class="fw-semibold">{{ $offer->receiver->name ?? 'N/A' }}</div>
                                    <small class="text-muted">{{ $offer->receiver->email ?? '' }}</small>
                                </div>
                            </div>
                            @if(is_array($offer->receiver_items) && count($offer->receiver_items))
                                <p class="fw-semibold small mb-2">Items Returned:</p>
                                @foreach($offer->receiver_items as $item)
                                    <span class="badge bg-info-subtle text-info rounded-pill px-2 me-1 mb-1">{{ $item }}</span>
                                @endforeach
                            @endif
                            <div class="mt-2">
                                <small class="text-muted">Confirmed: {{ $offer->receiver_confirmed ? '✅ Yes' : '⏳ No' }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 mt-4">
                <div class="card-body p-4">
                    <div class="d-flex flex-column flex-md-row justify-content-between gap-3 mb-4">
                        <div>
                            <h5 class="fw-bold mb-1">
                                <i class="fas fa-comments text-primary me-2"></i>Conversation Review
                            </h5>
                            <p class="text-muted small mb-0">
                                Messages between the exchange participants for moderation and fraud prevention.
                            </p>
                        </div>
                        <div class="d-flex align-items-start gap-2">
                            <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2">
                                {{ $messages->count() }} messages
                            </span>
                            @if($messages->contains('offer_id', $offer->id))
                                <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">
                                    Offer linked
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="admin-offer-chat">
                        @forelse($messages as $message)
                            @php
                                $isSender = (int) $message->sender_id === (int) $offer->sender_id;
                                $author = $message->sender;
                                $avatar = $author?->profilePhotoPath ?? asset('media/demo-img.png');
                            @endphp

                            <div class="admin-offer-chat-row {{ $isSender ? 'is-sender' : 'is-receiver' }}">
                                <img src="{{ $avatar }}" alt="{{ $author?->name ?? 'User' }}" class="admin-offer-chat-avatar">
                                <div class="admin-offer-chat-content">
                                    <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
                                        <span class="fw-semibold small">{{ $author?->name ?? 'Deleted user' }}</span>
                                        <span class="text-muted small">{{ $message->created_at?->format('d M Y, H:i') }}</span>
                                        @if((int) $message->offer_id === (int) $offer->id)
                                            <span class="badge bg-success-subtle text-success rounded-pill">Offer #{{ $offer->id }}</span>
                                        @endif
                                        @if((int) $message->selling_post_id === (int) $offer->selling_post_id)
                                            <span class="badge bg-info-subtle text-info rounded-pill">This post</span>
                                        @endif
                                    </div>

                                    <div class="admin-offer-chat-bubble">
                                        @if($message->contact)
                                            <div class="admin-offer-chat-text">{{ $message->contact }}</div>
                                        @else
                                            <div class="text-muted fst-italic small">No text message.</div>
                                        @endif

                                        @if($message->thumbnails->isNotEmpty())
                                            <div class="admin-offer-chat-attachments">
                                                @foreach($message->thumbnails as $attachment)
                                                    @php
                                                        $attachmentUrl = $attachment->src && \Illuminate\Support\Facades\Storage::disk('public')->exists($attachment->src)
                                                            ? \Illuminate\Support\Facades\Storage::url($attachment->src)
                                                            : null;
                                                        $isImage = in_array(strtolower($attachment->extension ?? ''), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                                    @endphp

                                                    @if($attachmentUrl && $isImage)
                                                        <a href="{{ $attachmentUrl }}" target="_blank" rel="noopener" class="admin-offer-chat-image">
                                                            <img src="{{ $attachmentUrl }}" alt="{{ $attachment->original_name ?? 'Attachment' }}">
                                                        </a>
                                                    @elseif($attachmentUrl)
                                                        <a href="{{ $attachmentUrl }}" target="_blank" rel="noopener" class="admin-offer-chat-file">
                                                            <i class="fas fa-paperclip me-1"></i>{{ $attachment->original_name ?? 'Attachment' }}
                                                        </a>
                                                    @endif
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5">
                                <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mb-3" style="width:64px;height:64px;">
                                    <i class="fas fa-comment-slash text-muted"></i>
                                </div>
                                <h6 class="fw-bold mb-1">No conversation found</h6>
                                <p class="text-muted small mb-0">There are no chat messages linked to these exchange participants yet.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">Timeline</h6>
                    <ul class="list-unstyled">
                        <li class="mb-3 d-flex align-items-start gap-2">
                            <i class="fas fa-circle text-success mt-1" style="font-size: 8px;"></i>
                            <div>
                                <small class="text-muted d-block">Created</small>
                                <span class="small fw-medium">{{ $offer->created_at->format('d M Y, H:i') }}</span>
                            </div>
                        </li>
                        <li class="mb-3 d-flex align-items-start gap-2">
                            <i class="fas fa-circle text-info mt-1" style="font-size: 8px;"></i>
                            <div>
                                <small class="text-muted d-block">Last Updated</small>
                                <span class="small fw-medium">{{ $offer->updated_at->format('d M Y, H:i') }}</span>
                            </div>
                        </li>
                    </ul>

                    <hr>

                    @if(!in_array($offer->status, ['completed', 'withdrawn', 'rejected']))
                        <form action="{{ route('admin.offers.force-cancel', $offer->id) }}" method="POST" onsubmit="return confirm('Force cancel this offer?')">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-outline-danger w-100 rounded-3">
                                <i class="fas fa-ban me-1"></i> Force Cancel
                            </button>
                        </form>
                    @endif

                    <a href="{{ route('admin.offers.index') }}" class="btn btn-light w-100 rounded-3 mt-2">
                        <i class="fas fa-arrow-left me-1"></i> Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .admin-offer-chat {
            max-height: 680px;
            overflow-y: auto;
            padding: 16px;
            background: #f8fafc;
            border: 1px solid #eef2f7;
            border-radius: 16px;
        }

        .admin-offer-chat-row {
            display: flex;
            gap: 12px;
            margin-bottom: 18px;
        }

        .admin-offer-chat-row.is-sender {
            flex-direction: row-reverse;
        }

        .admin-offer-chat-avatar {
            width: 40px;
            height: 40px;
            flex: 0 0 40px;
            border-radius: 999px;
            object-fit: cover;
            background: #e9ecef;
        }

        .admin-offer-chat-content {
            max-width: min(720px, 82%);
        }

        .admin-offer-chat-row.is-sender .admin-offer-chat-content {
            text-align: right;
        }

        .admin-offer-chat-bubble {
            display: inline-block;
            max-width: 100%;
            padding: 12px 14px;
            background: #fff;
            border: 1px solid #edf2f7;
            border-radius: 14px;
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.04);
            text-align: left;
        }

        .admin-offer-chat-row.is-sender .admin-offer-chat-bubble {
            background: #ecfdf3;
            border-color: #d1fadf;
        }

        .admin-offer-chat-text {
            white-space: pre-wrap;
            overflow-wrap: anywhere;
            line-height: 1.55;
            color: #243447;
        }

        .admin-offer-chat-attachments {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 10px;
        }

        .admin-offer-chat-image {
            display: block;
            width: 104px;
            height: 104px;
            overflow: hidden;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
            background: #fff;
        }

        .admin-offer-chat-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .admin-offer-chat-file {
            display: inline-flex;
            align-items: center;
            max-width: 260px;
            padding: 8px 10px;
            border-radius: 10px;
            background: #fff;
            border: 1px solid #e5e7eb;
            color: #2563eb;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            overflow-wrap: anywhere;
        }

        @media (max-width: 767.98px) {
            .admin-offer-chat {
                padding: 12px;
            }

            .admin-offer-chat-content {
                max-width: calc(100% - 52px);
            }
        }
    </style>
@endpush
