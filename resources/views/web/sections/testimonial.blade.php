  <section class="rs-user-area fix">
      <div class="rs-user-bg pb-96 p-relative jarallax" data-bg-img="{{ asset('assets/frontend/img/bg/user-bg.png') }}">
          <div class="rs-user-shape pt-96">
              <div class="container">
                  <div class="row">
                      <div class="rs-section-title-wrapper text-center mb-32 p-relative z-11 wow tpFadeInUp"
                          data-wow-duration="1s" data-wow-delay=".01s">
                          <h2 class="rs-section-title fnw-600 mb-10" data-color="#fff">
                              {{ __('Explore Our Marketplace') }}
                          </h2>
                          <p data-color="#fff">
                              {{ __('Thousands of listings, daily offers, and happy users—our marketplace grows with every') }}
                              <br> {{ __('product shared and every deal made') }}.
                          </p>
                      </div>
                  </div>
                  <div class="row rs-user-box-row g-4">
                      @foreach ($testimonials as $testimonial)
                          <div class="col-xl-4 col-lg-4 col-md-7 col-10">
                              <div class="rs-user-box wow tpFadeInUp" data-wow-duration="1s" data-wow-delay=".01s">
                                  <div class="rs-user-top d-flex align-items-center mb-6 gap-8">
                                      <div class="rs-user-img">
                                          <a href="javascript:void(0)">
                                              <img src="{{ $testimonial->thumbnail_path }}" class="rounded-circle"
                                                  style="width:60px; height:60px;">
                                          </a>
                                      </div>
                                      <div class="rs-user-name">
                                          <a href="javascript:void(0)">
                                              {{ $testimonial->name }}
                                          </a>
                                          <span>
                                              {{ $testimonial->designation }}
                                          </span>
                                      </div>
                                  </div>
                                  <div class="rs-user-bottom h-100">
                                      <div class="rs-user-rating">
                                          <div class="mb-3 text-warning fs-5">
                                              @for ($i = 1; $i <= 5; $i++)
                                                  @if ($i <= $testimonial->rating)
                                                      <i class="fas fa-star"></i>
                                                  @else
                                                      <i class="far fa-star"></i>
                                                  @endif
                                              @endfor
                                          </div>
                                      </div>
                                      <div class="rs-user-text" transfrom:translateY(-5PX);>
                                          <p>
                                              {{ $testimonial->description }}
                                          </p>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      @endforeach

                  </div>
              </div>
          </div>
      </div>
  </section>
