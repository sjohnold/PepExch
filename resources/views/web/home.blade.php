@extends('web.layouts.master')
@section('content')
  <!-- hero area start -->
  @include('web.sections.hero')
  <!-- hero area end -->

  <!-- category area start -->
  @include('web.sections.category')
  <!-- category area end -->

  <!-- product area start -->
  @include('web.sections.product-feature')
  <!-- product area end -->


  <!-- product sell start -->
  @include('web.sections.sell-post')
  <!-- product sell end -->

  <!-- product count start -->
  @include('web.sections.count')
  <!-- product count end -->

  <!-- product area start -->
  @include('web.sections.new-product')
  <!-- product area end -->

  <!-- user area start -->
  @include('web.sections.testimonial')
  <!-- user area end -->.

  <!-- mobile app area start -->
  @include('web.sections.mobile-app')
  <!-- mobile app area end -->
@endsection
