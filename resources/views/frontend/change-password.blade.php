@extends('layouts.front.master')

@section('title')

Trip Book

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

                        <h2 class="text-center">@lang('change-pass.change_pass')</h2>

                        @if(session()->has('success'))

                            <span class="text-success text-center">{{ Session::get('success') }}</span>

                        @endif

                        @if(session()->has('error'))

                            <span class="text-danger text-center">{{ Session::get('error') }}</span>

                        @endif

                    </div>

                    <div class="pt-4 pb-5 px-5">

                        <h5 id="scroll-description" class="font-size-21 font-weight-bold text-dark mb-4">

                            @lang('change-pass.let_us_know')

                        </h5>

                        <!-- Contacts Form -->

                        @if(app()->getLocale() == 'ur')

                            <form class="js-validate" action="{{ url('ur/user-update-password') }}" method="POST">

                        @elseif(app()->getLocale() == 'ar')

                            <form class="js-validate" action="{{ url('ar/user-update-password') }}" method="POST">

                        @else

                            <form class="js-validate" action="{{ url('user-update-password') }}" method="POST">

                        @endif



                            @csrf

                            <div class="row">

                                <!-- Input -->

                                <div class="col-sm-12 mb-4">

                                    <div class="js-form-message">

                                        <label class="form-label">

                                            @lang('change-pass.old_pass')<span class="text-danger">*</span>

                                        </label>

                                        <input type="password" class="form-control" name="old_password" placeholder="@lang('change-pass.old_pass')" aria-label="Name" required

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

                                            @lang('change-pass.new_pass')<span class="text-danger">*</span>

                                        </label>

                                        <input type="password" class="form-control" name="new_password" placeholder="@lang('change-pass.new_pass')" aria-label="Name" required

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

                                            @lang('change-pass.con_pass')<span class="text-danger">*</span>

                                        </label>

                                        <input type="password" class="form-control" name="confirm_password" placeholder="@lang('change-pass.con_pass')" aria-label="Name" required

                                        data-msg="Required."

                                        data-error-class="u-has-error"

                                        data-success-class="u-has-success">

                                    </div>

                                </div>

                                <!-- End Input -->



                            </div>

                            <div class="row">

                                <div class="col-sm-12 align-self-end">

                                    <div class="text-center">

                                        <button type="submit" class="btn btn-primary btn-wide rounded-sm transition-3d-hover font-size-16 font-weight-bold py-3">@lang('change-pass.update')</button>

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

