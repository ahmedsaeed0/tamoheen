@extends('layouts.front.master')
@section('title')
Ship Review
@endsection
@section('front-additional-css')

@endsection
@section('content')
@include('layouts.front.include.header1')
<main id="content" class="bg-gray space-2">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-xl-12">
                <div class="mb-5 shadow-soft bg-white rounded-sm">
                    <div class="py-3 px-4 px-xl-12 border-bottom">
                        <h2 class="text-center">@lang('review.review')</h2>
                    </div>
                    <div class="pt-4 pb-5 px-5">
                        <h5 id="scroll-description" class="font-size-21 font-weight-bold text-dark mb-4">
                            @lang('review.let_us_know')
                        </h5>
                        <!-- Contacts Form -->
                        @if(app()->getLocale() == 'ur')
                            <form class="js-validate" action="{{ url('ur/ship-review-submit') }}" method="POST">
                        @elseif(app()->getLocale() == 'ar')
                            <form class="js-validate" action="{{ url('ar/ship-review-submit') }}" method="POST">
                        @else
                            <form class="js-validate" action="{{ url('ship-review-submit') }}" method="POST">
                        @endif
                            @csrf
                            <div class="row">
                                <!-- Input -->
                                <div class="col-sm-12 mb-4">
                                    <div class="js-form-message">
                                        <label class="form-label">
                                            @lang('review.rating')
                                        </label>
                                        <select class="form-control js-select selectpicker dropdown-select" required="" data-msg="Please select Title." data-error-class="u-has-error" data-success-class="u-has-success"
                                            data-live-search="true"
                                            data-style="form-control font-size-16 border-width-2 border-gray font-weight-normal" name="rating">
                                            <option>@lang('review.select_rating')</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- End Input -->

                                <input type="hidden" name="ship_booking_id" value="{{ $tripbooking->id }}">
                                <input type="hidden" name="to_id" value="{{ $tripbooking->trip->user_id }}">

                                <!-- Input -->
                                <div class="col-sm-12 mb-4">
                                    <div class="js-form-message">
                                        <label class="form-label">
                                            @lang('review.review')
                                        </label>
                                        <input type="text" class="form-control" name="review" placeholder="@lang('review.review')" aria-label="Name" required
                                        data-msg="Required."
                                        data-error-class="u-has-error"
                                        data-success-class="u-has-success">
                                    </div>
                                </div>
                                <!-- End Input -->
                                <div class="w-100"></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 align-self-end">
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary btn-wide rounded-sm transition-3d-hover font-size-16 font-weight-bold py-3">@lang('review.submit')</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- End Contacts Form -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
@section('front-additional-js')
@endsection