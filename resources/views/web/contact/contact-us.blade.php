@extends('web.layouts.master')
@section('content')

        <section class="rs-contact-area mt-40 mb-40 pt-48 pb-48" data-bg-color="#F6F7F9">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-12">
                        <div class="rs-contact-img br-16 wow tpFadeInUp" data-wow-duration="1s"
                            data-wow-delay=".01s">
                            <img src="{{ asset('assets/frontend/img/contact/contact-01.jpg') }}" alt="">
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-12">
                        <div class="rs-contact-content d-flex flex-column h-100 justify-content-between wow tpFadeInUp"
                            data-wow-duration="1s" data-wow-delay=".01s">
                            <h2 class="rs-contact-title mb-20">
                                {{ __('Contact Us') }}
                            </h2>
                            <p class="rs-contact-text mb-24">
                                {{ __('We’re here to help with any questions, feedback, or support you need') }}
                            </p>

                            <div class="rs-contact-social d-flex align-items-center gap-40 mb-24 pb-24">
                                @foreach ($socialLinks as $item)
                                    @if ($item->url)
                                        <a href="{{ $item->url }}" target="_blank" class="rs-contact-social-icon"> <img src="{{$item->icon }}" alt=""> </a>
                                    @endif
                                @endforeach
                            </div>

                            <div class="rs-contact-form">
                                <form action="{{ route('guest.contact.store') }}" method="POST">
                                    @csrf
                                    <div class="rs-contact-input-item">
                                        <h4 class="rs-contact-input-title mb-12">
                                            {{ __('Name') }}
                                        </h4>
                                        <input type="text" name="name" placeholder="Enter Your Name" value="{{ old('name') }}">
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="rs-contact-input-item">
                                        <h4 class="rs-contact-input-title mb-12">
                                            {{ __(' Email') }}
                                        </h4>
                                        <input type="email" name="email" placeholder="Enter Your Email" value="{{ old('email') }}">
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="rs-contact-input-item">
                                        <h4 class="rs-contact-input-title mb-12">
                                             {{ __('Subject') }}
                                        </h4>
                                        <input type="text" name="subject" placeholder="Enter Your Subject" value="{{ old('subject') }}">
                                        @error('subject')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="rs-contact-input-item">
                                        <h4 class="rs-contact-input-title mb-12">
                                            {{ __(' Message') }}
                                        </h4>
                                        <textarea name="message" placeholder="Write Your Message">{{ old('message') }}</textarea>
                                        @error('message')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <button type="submit" class="rs-btn rs-contact-btn">
                                         {{ __('Submit Message') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- contact area end -->

        <!-- contact info start -->
        <section class="rs-contact-info-area pt-48 pb-48 mb-1"  data-bg-color="#17181D">
            <div class="container">
                <div class="row">
                    <div class="rs-contact-info-content">
                        <h3 class="rs-contact-info-title mb-24 text-center">
                            {{ __('We\'re here to help! ') }}

                        </h3>
                        <div class="rs-contact-form-contact">
                            <a href="mailto:{{ $supportMailSetting->data->value }}" class="d-flex align-items-center gap-8">
                                <span class="rs-contact-form-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="23"
                                        viewBox="0 0 26 23" fill="none">
                                        <path
                                            d="M21 22.666H5C1.776 22.666 0 20.89 0 17.666V5.66602C0 2.44202 1.776 0.666016 5 0.666016H21C24.224 0.666016 26 2.44202 26 5.66602V17.666C26 20.89 24.224 22.666 21 22.666ZM5 2.66602C2.89733 2.66602 2 3.56335 2 5.66602V17.666C2 19.7687 2.89733 20.666 5 20.666H21C23.1027 20.666 24 19.7687 24 17.666V5.66602C24 3.56335 23.1027 2.66602 21 2.66602H5ZM14.3721 12.5714L20.9212 7.80868C21.3679 7.48468 21.4666 6.85802 21.1413 6.41136C20.8173 5.96602 20.1935 5.86468 19.7441 6.19135L13.1947 10.954C13.0773 11.0394 12.9214 11.0394 12.804 10.954L6.25456 6.19135C5.80389 5.86468 5.18142 5.96736 4.85742 6.41136C4.53209 6.85802 4.63081 7.48334 5.07747 7.80868L11.6266 12.5727C12.0373 12.8713 12.5187 13.0193 12.9987 13.0193C13.4787 13.0193 13.9627 12.87 14.3721 12.5714Z"
                                            fill="#DD5454" />
                                    </svg>
                                </span>
                                {{ $supportMailSetting->data->value }}
                            </a>
                            <a href="tel:{{ $supportContactSetting->data->value }}" class="d-flex align-items-center gap-8">
                                <span class="rs-contact-form-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26"
                                        viewBox="0 0 26 26" fill="none">
                                        <path
                                            d="M19.0678 26.0032C18.4558 26.0032 17.8399 25.9205 17.2319 25.7539C9.01185 23.4979 2.50383 16.9939 0.246499 8.77922C-0.266835 6.91122 0.0144285 4.96454 1.0411 3.30054C2.07176 1.62854 3.76651 0.448538 5.69051 0.0645379C6.97051 -0.191462 8.23584 0.379214 8.88517 1.47388L10.9692 4.99386C11.9812 6.70319 11.4783 8.90453 9.82365 10.0059L8.31583 11.0085C9.72517 13.9019 12.0956 16.2792 14.977 17.6872L15.9932 16.1712C17.1012 14.5192 19.3025 14.0245 21.0105 15.0419L24.5346 17.1432C25.6253 17.7939 26.1892 19.0672 25.9412 20.3099C25.5572 22.2339 24.3771 23.9285 22.7065 24.9592C21.5838 25.6499 20.3345 26.0032 19.0678 26.0032ZM6.30249 2.00053C6.23716 2.00053 6.17052 2.00722 6.10652 2.02055C4.70119 2.30189 3.48386 3.14852 2.7452 4.34986C2.0132 5.53652 1.81183 6.92187 2.17716 8.24854C4.24783 15.7859 10.2198 21.7552 17.7611 23.8245C19.0891 24.1885 20.4703 23.9859 21.6557 23.2552C22.8557 22.5152 23.7039 21.2965 23.9799 19.9152C24.0626 19.5005 23.8745 19.0752 23.5092 18.8579L19.9864 16.7565C19.1931 16.2845 18.169 16.5152 17.6544 17.2819L16.1677 19.5019C15.9011 19.8992 15.3866 20.0512 14.9519 19.8672C11.0012 18.2152 7.78655 14.9939 6.13322 11.0285C5.94922 10.5859 6.10369 10.0765 6.50236 9.8112L8.7172 8.33785C9.4852 7.82719 9.71847 6.80453 9.2478 6.01119L7.16382 2.49252C6.98115 2.18318 6.65049 2.00053 6.30249 2.00053Z"
                                            fill="#DD5454" />
                                    </svg>
                                </span>
                                {{ $supportContactSetting->data->value }}
                            </a>
                            <a href="javascript:void(0)" class="d-flex align-items-center gap-8">
                                <span class="rs-contact-form-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="26"
                                        viewBox="0 0 24 26" fill="none">
                                        <path
                                            d="M11.9987 0C5.56536 0 0.332031 5.23333 0.332031 11.6667C0.332031 18.4907 6.59469 22.6266 10.7387 25.3639L11.444 25.832C11.612 25.944 11.8054 26 11.9987 26C12.192 26 12.3854 25.944 12.5534 25.832L13.2587 25.3639C17.4027 22.6266 23.6654 18.4907 23.6654 11.6667C23.6654 5.23333 18.432 0 11.9987 0ZM12.1574 23.6947L11.9987 23.8001L11.84 23.6947C7.82669 21.044 2.33203 17.4147 2.33203 11.6667C2.33203 6.336 6.66803 2 11.9987 2C17.3294 2 21.6654 6.336 21.6654 11.6667C21.6654 17.4147 16.1694 21.0453 12.1574 23.6947ZM11.9987 7.33333C9.60936 7.33333 7.66536 9.27733 7.66536 11.6667C7.66536 14.056 9.60936 16 11.9987 16C14.388 16 16.332 14.056 16.332 11.6667C16.332 9.27733 14.388 7.33333 11.9987 7.33333ZM11.9987 14C10.712 14 9.66536 12.9533 9.66536 11.6667C9.66536 10.38 10.712 9.33333 11.9987 9.33333C13.2854 9.33333 14.332 10.38 14.332 11.6667C14.332 12.9533 13.2854 14 11.9987 14Z"
                                            fill="#DD5454" />
                                    </svg>
                                </span>
                                {{ $addressSetting->data->value }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
@endsection
