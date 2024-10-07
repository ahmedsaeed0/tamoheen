@extends('layouts.front.master')
@section('title')
Trip Complain
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
                    @if(empty($complain))
                    <div class="py-3 px-4 px-xl-12 border-bottom">
                        <h2 class="text-center">@lang('complain.complain')</h2>
                    </div>
                    <div class="pt-4 pb-5 px-5">
                        <h5 id="scroll-description" class="font-size-21 font-weight-bold text-dark mb-4">
                            @lang('complain.let_us_know')
                        </h5>
                        <!-- Contacts Form -->
                        @if(app()->getLocale() == 'ur')
                            <form class="js-validate" action="{{ url('ur/complain-submit') }}" method="POST">
                        @elseif(app()->getLocale() == 'ar')
                            <form class="js-validate" action="{{ url('ar/complain-submit') }}" method="POST">
                        @else
                            <form class="js-validate" action="{{ url('complain-submit') }}" method="POST">
                        @endif
                            @csrf
                            <div class="row">

                                <input type="hidden" name="trip_id" value="{{ $tripbooking->trip->id }}">
                                <input type="hidden" name="to_id" value="{{ $tripbooking->trip->user_id }}">
                                <input type="hidden" name="type" value="{{ $type }}">

                                <!-- Input -->
                                <div class="col-sm-12 mb-4">
                                    <div class="js-form-message">
                                        <label class="form-label">
                                            @lang('complain.title')
                                        </label>
                                        <input type="text" class="form-control" name="title" placeholder="@lang('complain.title')" aria-label="Name" required
                                        data-msg="Required."
                                        data-error-class="u-has-error"
                                        data-success-class="u-has-success">
                                    </div>
                                </div>
                                <!-- End Input -->
                                <!-- Input -->
                                <div class="col-sm-12 mb-4">
                                    <div class="js-form-message">
                                        <label class="form-label">
                                            @lang('complain.description')
                                        </label>
                                        <input type="text" class="form-control" name="description" placeholder="@lang('complain.description')" aria-label="Name" required
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
                                        <button type="submit" class="btn btn-primary btn-wide rounded-sm transition-3d-hover font-size-16 font-weight-bold py-3">@lang('complain.submit')</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        @endif
                        @if(!empty($complain))
                            <div class="row">
                                <div class="col-md-12">
                                   <strong>  @lang('complain.title')</strong>: {{$complain['title']}}
                                </div>
                                <div class="col-md-12">
                                    <strong>@lang('complain.description')</strong>: {{$complain['description']}}
                                </div>
                            </div>
                        @endif
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