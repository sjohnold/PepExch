<footer class="rs-footer-area mt-1" data-bg-color="#17181D">
    <div class="container">
        <div class="rs-footer-top pb-24 mb-24">
            <div class="row align-items-center">
                <div class="col-xl-8 col-lg-8 col-md-5 col-12">
                    <div class="rs-footer-logo">
                        <a href="javascript:void(0)">
                            <img src="{{ $footerLogo->footer_url ?? 'https://placehold.jp/150x50.png' }}"
                                alt="Footer Logo" style="max-height: 30px">
                        </a>
                    </div>

                    <div class="rs-footer-description mt-3" style="max-width:750px">
                        <p class="mb-0" style="font-size: 0.9rem; line-height: 1.6; color:whitesmoke">
                            {{ $footerSubtitle->value ?? '' }}
                        </p>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-7 col-12">
                    <div class="rs-footer-top-right">
                        <div class="rs-footer-social d-flex align-items-center gap-3 justify-content-end mb-24">
                            @if (isset($socialLinks) && is_array($socialLinks))
                                @foreach ($socialLinks as $item)
                                    @php
                                        $item = (object) $item;
                                    @endphp
                                    @if (!empty($item->url))
                                        <a href="{{ $item->url }}" target="_blank" rel="noopener noreferrer"
                                            class="social-icon-link social-{{ $item->icon }}"
                                            title="{{ $item->label }}">
                                            <i class="fab fa-{{ $item->icon }}"></i>
                                        </a>
                                    @endif
                                @endforeach
                            @endif
                        </div>

                        <div class="rs-footer-download-app d-flex align-items-center justify-content-end gap-15">
                            <a href="{{ $allData->play_store_url?? '#' }}" target="_blank" rel="noopener noreferrer">
                                     <img class="play-store-logo" src="{{ asset('assets/frontend/img/mobile-app/play-store-logo.png') }}"
                                        alt="">
                                        <img class="play-store-text" src="{{ asset('assets/frontend/img/mobile-app/play-store-logo-text.png') }}"
                                        alt="">
                            </a>
                            <a href="{{ $allData->app_store_url ?? '#' }}" target="_blank" rel="noopener noreferrer">
                                <img src="{{ asset('assets/frontend/img/icon/download-apple.png') }}" alt="Play Store">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            @php
                $activeCardsCount = count($footerMenuCards);
                $colClass = 'col-xl-3 col-lg-3 col-md-6'; // Default 4 columns

                // Dynamic column width based on active cards
                if ($activeCardsCount == 3) {
                    $colClass = 'col-xl-4 col-lg-4 col-md-4';
                } elseif ($activeCardsCount == 2) {
                    $colClass = 'col-xl-6 col-lg-6 col-md-6';
                } elseif ($activeCardsCount == 1) {
                    $colClass = 'col-xl-12 col-lg-12 col-md-12';
                }
            @endphp

            @if (isset($footerMenuCards) && count($footerMenuCards) > 0)
                @foreach ($footerMenuCards as $card)
                    <div class="{{ $colClass }}" data-footer-id="{{ $card['id'] }}">
                        <div class="rs-footer-widget">
                            <div class="rs-footer-widget-content">
                                <h3 class="rs-footer-widget-title">{{ $card['label'] }}</h3>

                                @if ($card['id'] === 'footer-info')
                                    {{-- Footer Contact Information --}}
                                    <div class="rs-footer-contact">
                                        @if (isset($card['items']) && is_array($card['items']))
                                            @foreach ($card['items'] as $item)
                                                @if ($item['id'] === 'support_mail' && isset($footerSupportMail->value))
                                                    <a href="mailto:{{ $footerSupportMail->value }}"
                                                        class="d-flex align-items-start gap-3 mb-3 contact-item">
                                                        <div class="contact-icon">
                                                            <i class="fas fa-envelope"></i>
                                                        </div>
                                                        <span
                                                            class="contact-text">{{ $footerSupportMail->value }}</span>
                                                    </a>
                                                @elseif($item['id'] === 'support_contact' && isset($footerContact->value))
                                                    <a href="tel:{{ $footerContact->value }}"
                                                        class="d-flex align-items-start gap-3 mb-3 contact-item">
                                                        <div class="contact-icon">
                                                            <i class="fas fa-phone-alt"></i>
                                                        </div>
                                                        <span class="contact-text">{{ $footerContact->value }}</span>
                                                    </a>
                                                @elseif($item['id'] === 'address' && isset($footerAddress->value))
                                                    <div class="d-flex align-items-start gap-3 mb-3 contact-item">
                                                        <div class="contact-icon">
                                                            <i class="fas fa-map-marker-alt"></i>
                                                        </div>
                                                        <span class="contact-text">{{ $footerAddress->value }}</span>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                @else
                                    {{-- Other Menu Sections - Dynamic Items with Custom URL --}}
                                    <div class="rs-footer-widget-menu">
                                        <ul>
                                            @if (isset($card['items']) && is_array($card['items']))
                                                @foreach ($card['items'] as $item)
                                                    <li>
                                                        @php
                                                            $itemId = $item['id'];
                                                            $itemLabel = $item['label'];
                                                            $itemUrl = '#';
                                                            $isExternal = false;

                                                            // Check if custom URL is set
                                                            if (!empty($item['url'])) {
                                                                $itemUrl = $item['url'];
                                                                // Check if URL is external
                                                                $isExternal =
                                                                    !str_starts_with($itemUrl, url('/')) &&
                                                                    !str_starts_with($itemUrl, '/') &&
                                                                    !str_starts_with($itemUrl, '#') &&
                                                                    (str_starts_with($itemUrl, 'http://') ||
                                                                        str_starts_with($itemUrl, 'https://'));
                                                            } else {
                                                                // Fallback to default route mapping
                                                                if ($card['id'] === 'quick-links') {
                                                                    switch ($itemId) {
                                                                        case 'subscription':
                                                                            $itemUrl = '#';
                                                                            break;
                                                                        case 'add_post':
                                                                            $itemUrl = route('product-ad');
                                                                            break;
                                                                        case 'login':
                                                                            $itemUrl = "javascript:toggleModal('sign_in_popup')";
                                                                        break;
                                                                        case 'registration':
                                                                            $itemUrl = "javascript:toggleModal('sign_up_popup')";
                                                                        break;
                                                                    }
                                                                } elseif ($card['id'] === 'company') {
                                                                    switch ($itemId) {
                                                                        case 'about_us':
                                                                            $itemUrl = route('about.us');
                                                                            break;
                                                                        case 'most_popular':
                                                                            $itemUrl = route('products');
                                                                            break;
                                                                        case 'terms':
                                                                            $itemUrl = route(
                                                                                'guest.pages',
                                                                                'terms-conditions',
                                                                            );
                                                                            break;
                                                                        case 'privacy':
                                                                            $itemUrl = route(
                                                                                'guest.pages',
                                                                                'privacy-policy',
                                                                            );
                                                                            break;
                                                                    }
                                                                } elseif ($card['id'] === 'help-support') {
                                                                    switch ($itemId) {
                                                                        case 'faq':
                                                                            $itemUrl = '#';
                                                                            break;
                                                                        case 'stay_safe':
                                                                            $itemUrl = '#';
                                                                            break;
                                                                        case 'contact':
                                                                            $itemUrl = route('contact.us');
                                                                            break;
                                                                    }
                                                                }
                                                            }
                                                        @endphp

                                                        <a href="{{ $itemUrl }}"
                                                            @if ($isExternal) target="_blank" rel="noopener noreferrer" @endif>
                                                            {{ __($itemLabel) }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <div class="row">
            <div class="rs-footer-copyright-area text-center">
                <p class="rs-footer-copyright-text">
                    {{ $footerCopyright->value ?? '© 2026 All Rights Reserved' }}
                </p>
                <div class="rs-footer-copyright-border p-relative"></div>
            </div>
        </div>
    </div>
</footer>

<style>
    /* Social Icons */
    .social-icon-link {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 45px;
        height: 45px;
        border-radius: 50%;
        color: white;
        font-size: 20px;
        transition: all 0.3s ease;
        text-decoration: none;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .social-icon-link:hover {
        transform: translateY(-4px) scale(1.05);
        box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
    }

    .social-facebook {
        background: linear-gradient(135deg, #1877f2 0%, #145dbf 100%);
    }

    .social-twitter {
        background: linear-gradient(135deg, #1da1f2 0%, #1a8cd8 100%);
    }

    .social-instagram {
        background: linear-gradient(135deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
    }

    .social-linkedin {
        background: linear-gradient(135deg, #0077b5 0%, #006399 100%);
    }

    .social-youtube {
        background: linear-gradient(135deg, #ff0000 0%, #cc0000 100%);
    }

    .social-github {
        background: linear-gradient(135deg, #333 0%, #1a1a1a 100%);
    }

    .social-whatsapp {
        background: linear-gradient(135deg, #25d366 0%, #1ebe57 100%);
    }

    .social-telegram {
        background: linear-gradient(135deg, #0088cc 0%, #006fa3 100%);
    }

    .social-tiktok {
        background: linear-gradient(135deg, #000000 0%, #333333 100%);
    }

    .social-pinterest {
        background: linear-gradient(135deg, #e60023 0%, #bd001c 100%);
    }

    /* Contact Information Styling */
    .rs-footer-contact .contact-item {
        color: white;
        text-decoration: none;
    }

    .contact-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        margin-top: 2px;
    }

    .contact-icon i {
        font-size: 16px;
        color: white;
    }

    .contact-text {
        font-size: 14px;
        line-height: 1.6;
        flex: 1;
    }

    /* Footer Menu */
    .rs-footer-widget-menu ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .rs-footer-widget-menu ul li {
        margin-bottom: 8px;
    }

    .rs-footer-widget-menu ul li a {
        color: white;
        text-decoration: none;
        font-size: 14px;
        display: inline-block;
    }
</style>
