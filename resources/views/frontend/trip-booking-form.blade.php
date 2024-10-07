@extends('layouts.front.master')

@section('title')

Trip Book

@endsection

@section('front-additional-css')

<style>

    .bootstrap-select .dropdown-menu.inner {

        text-align: start !important;

    }



    body{

        text-align:start !important;

    }



    .filter-option-inner-inner{

        text-align: start !important;

    }

</style>

@endsection



@section('content')

@include('layouts.front.include.header1')

<main id="content" class="bg-gray space-2">

    <div class="container">

        <div class="row">

            <div class="col-lg-12 col-xl-12">

                <div class="mb-5 shadow-soft bg-white rounded-sm">

                    <div class="py-3 px-4 px-xl-12 border-bottom">

                        <h2 class="text-center">@lang('content.booking_form')</h2>

                        @if(session()->has('success'))

                            <span class="text-success">{{ Session::get('success') }}</span>

                        @endif

                        @if(session()->has('error'))

                            <span class="text-success">{{ Session::get('error') }}</span>

                        @endif

                    </div>

                    <div class="pt-4 pb-5 px-5">

                        <h5 id="scroll-description" class="font-size-21 font-weight-bold text-dark mb-4">

                            @lang('content.let_us_know')

                        </h5>

                        <!-- Contacts Form -->



                            @if(app()->getLocale() == 'ur')

                                <form class="js-validate" action="{{ url('ur/booking-submit') }}" method="POST">

                            @elseif(app()->getLocale() == 'ar')

                                <form class="js-validate" action="{{ url('ar/booking-submit') }}" method="POST">

                            @else

                                <form class="js-validate" action="{{ url('/booking-submit') }}" method="POST">

                            @endif

                            @csrf

                            @for($i = 1; $i <= $number_of_person; $i++)

                            @if($i  <= '10')

                                <h3>@lang('content.passenger') {{ $i }}</h3>

                                <input type="hidden" name="trip_id" value="{{ $trip->id }}">

                                <input type="hidden" name="user_id" value="{{ Auth::id() }}">

                                <input type="hidden" name="number_of_passenger" value="{{ $number_of_person }}">

                            @if($i == 1 && Auth::check())

                            <div class="row">

                                <!-- Input -->

                                <div class="col-sm-6 mb-4">

                                    <div class="js-form-message">

                                        <label class="form-label">

                                            @lang('content.title')

                                        </label>

                                        <select class="form-control text-start js-select selectpicker dropdown-select" data-msg="Please select Title." data-error-class="u-has-error" data-success-class="u-has-success"

                                            data-live-search="true"

                                            data-style="form-control font-size-16 border-width-2 border-gray font-weight-normal" name="title[]" required>

                                            <option value="">@lang('content.select_title')</option>

                                            <option value="1" {{ (Auth::user()->title == 1) ? 'selected' : '' }}>Mr</option>

                                            <option value="2" {{ (Auth::user()->title == 2) ? 'selected' : '' }}>Mrs</option>

                                        </select>

                                    </div>

                                </div>

                                <!-- End Input -->



                                <!-- Input -->

                                <div class="col-sm-6 mb-4">

                                    <div class="js-form-message">

                                        <label class="form-label">

                                            @lang('content.name')

                                        </label>



                                        <input type="text" class="form-control" name="name[]" placeholder="@lang('content.name')" aria-label="Name" required

                                        data-msg="Please enter your last name."

                                        data-error-class="u-has-error"

                                        data-success-class="u-has-success" value="{{ Auth::user()->name }}">

                                    </div>

                                </div>

                                <!-- End Input -->



                                <!-- Input -->

                                <div class="col-sm-6 mb-4">

                                    <div class="js-form-message">

                                        <label class="form-label">

                                            @lang('content.email')

                                        </label>



                                        <input type="email" class="form-control" name="email[]" placeholder="@lang('content.email')" aria-label="Enter Email" required

                                        data-msg="Please enter a valid email address."

                                        data-error-class="u-has-error"

                                        data-success-class="u-has-success" value="{{ Auth::user()->email }}">

                                    </div>

                                </div>

                                <!-- End Input -->



                                <!-- Input -->

                                <div class="col-sm-6 mb-4">

                                    <div class="js-form-message">

                                        <label class="form-label">

                                            @lang('content.phone')

                                        </label>



                                        <input type="text" class="form-control" name="mobile[]" placeholder="@lang('content.phone')" aria-label="+90 (254) 458 96 32" required

                                        data-msg="Please enter a valid phone number."

                                        data-error-class="u-has-error"

                                        data-success-class="u-has-success" value="{{ Auth::user()->mobile }}">

                                    </div>

                                </div>

                                <!-- End Input -->



                                <div class="w-100"></div>



                                <!-- Input -->

                                <div class="col-sm-6 mb-4">

                                    <div class="js-form-message">

                                        <label class="form-label">

                                            @lang('content.identity_type')

                                        </label>

                                        <select class="form-control text-start js-select selectpicker dropdown-select" required="" data-msg="Please select identity type." data-error-class="u-has-error" data-success-class="u-has-success"

                                            data-live-search="true"

                                            data-style="form-control font-size-16 border-width-2 border-gray font-weight-normal" name="identity_type[]">

                                            <option value="">@lang('content.select_identity_type')</option>

                                            <option value="1" {{ (Auth::user()->identity_type == 1) ? 'selected' : '' }}>@lang('content.nid')</option>

                                            <option value="2" {{ (Auth::user()->identity_type == 2) ? 'selected' : '' }}>@lang('content.passport')</option>

                                            <option value="3" {{ (Auth::user()->identity_type == 3) ? 'selected' : '' }}>@lang('content.iqma_number')</option>

                                        </select>

                                    </div>

                                </div>

                                <!-- End Input -->



                                <!-- Input -->

                                <div class="col-sm-6 mb-4">

                                    <div class="js-form-message">

                                        <label class="form-label">

                                            @lang('content.identity_number')

                                        </label>



                                        <input type="text" class="form-control" name="identity_number[]" placeholder="@lang('content.identity_number')" aria-label="432686432" required

                                        data-msg="Required"

                                        data-error-class="u-has-error"

                                        data-success-class="u-has-success" value="{{ Auth::user()->identity_number }}">

                                    </div>

                                </div>

                                <!-- End Input -->

                                <div class="w-100"></div>

                            </div>

                            @else

                                <div class="row">

                                    <!-- Input -->

                                    <div class="col-sm-6 mb-4">

                                        <div class="js-form-message">

                                            <label class="form-label">

                                                @lang('content.title')

                                            </label>

                                            <select class="form-control text-start js-select selectpicker dropdown-select" data-msg="Please select Title." data-error-class="u-has-error" data-success-class="u-has-success"

                                                data-live-search="true"

                                                data-style="form-control font-size-16 border-width-2 border-gray font-weight-normal" name="title[]" required>

                                                <option value="">@lang('content.select_title')</option>

                                                <option value="1">@lang('content.mr')</option>

                                                <option value="2">@lang('content.mrs')</option>

                                            </select>

                                        </div>

                                    </div>

                                    <!-- End Input -->



                                    <!-- Input -->

                                    <div class="col-sm-6 mb-4">

                                        <div class="js-form-message">

                                            <label class="form-label">

                                                @lang('content.name')

                                            </label>



                                            <input type="text" class="form-control" name="name[]" placeholder="@lang('content.name')" aria-label="Name" required

                                            data-msg="Please enter your last name."

                                            data-error-class="u-has-error"

                                            data-success-class="u-has-success">

                                        </div>

                                    </div>

                                    <!-- End Input -->



                                    <!-- Input -->

                                    <div class="col-sm-6 mb-4">

                                        <div class="js-form-message">

                                            <label class="form-label">

                                                @lang('content.email')

                                            </label>



                                            <input type="email" class="form-control" name="email[]" placeholder="@lang('content.email')" aria-label="Enter Email" required

                                            data-msg="Please enter a valid email address."

                                            data-error-class="u-has-error"

                                            data-success-class="u-has-success">

                                        </div>

                                    </div>

                                    <!-- End Input -->



                                    <!-- Input -->

                                    <div class="col-sm-6 mb-4">

                                        <div class="js-form-message">

                                            <label class="form-label">

                                                @lang('content.phone')

                                            </label>



                                            <input type="text" class="form-control" name="mobile[]" placeholder="@lang('content.phone')" aria-label="+90 (254) 458 96 32" required

                                            data-msg="Please enter a valid phone number."

                                            data-error-class="u-has-error"

                                            data-success-class="u-has-success">

                                        </div>

                                    </div>

                                    <!-- End Input -->



                                    <div class="w-100"></div>



                                    <!-- Input -->

                                    <div class="col-sm-6 mb-4">

                                        <div class="js-form-message">

                                            <label class="form-label">

                                                @lang('content.identity_type')

                                            </label>

                                            <select class="form-control text-start js-select selectpicker dropdown-select" required="" data-msg="Please select identity type." data-error-class="u-has-error" data-success-class="u-has-success"

                                                data-live-search="true"

                                                data-style="form-control font-size-16 border-width-2 border-gray font-weight-normal" name="identity_type[]">

                                                <option value="">@lang('content.select_identity_type')</option>

                                                <option value="1">@lang('content.nid')</option>

                                                <option value="2">@lang('content.passport')</option>

                                                <option value="3">@lang('content.iqma_number')</option>

                                            </select>

                                        </div>

                                    </div>

                                    <!-- End Input -->



                                    <!-- Input -->

                                    <div class="col-sm-6 mb-4">

                                        <div class="js-form-message">

                                            <label class="form-label">

                                                @lang('content.identity_number')

                                            </label>



                                            <input type="text" class="form-control" name="identity_number[]" placeholder="@lang('content.identity_number')" aria-label="432686432" required

                                            data-msg="Required"

                                            data-error-class="u-has-error"

                                            data-success-class="u-has-success">

                                        </div>

                                    </div>

                                    <!-- End Input -->

                                    <div class="w-100"></div>

                                </div>

                            @endif

                            @endif

                            @endfor

                            <div class="row">

                                <div class="col-sm-12 align-self-end">

                                    <div class="text-center">

                                        <button type="submit" class="btn btn-primary btn-wide rounded-sm transition-3d-hover font-size-16 font-weight-bold py-3">@lang('content.booked')</button>

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

