@hasrole('user')
    <script>
        window.location.href = '{{url("home")}}';
    </script>
@endhasrole
@hasrole('partner')
    <script>
        window.location.href = '{{url("home")}}';
    </script>
@endhasrole
@extends('layouts.front.master')
@section('title')
Login
@endsection
@section('front-additional-css')

@endsection
@section('content')
@include('layouts.front.include.header1')
<main id="content">
	<div class="container">

        <div class="row">
            <div class="col-md-6 mx-auto">
        	<h1 class="text-center">@lang('content.login_panel')</h1>
        <div class="card rounded-xs">
                <!-- Login -->
                <div id="login" class="animated fadeIn">
                    <form class="js-validate" novalidate="novalidate" method="post" action="{{ route('login') }}">
                    @csrf
                    <!-- Header -->
                    <div class="card-header text-center">
                        <h3 class="h5 mb-0 font-weight-semi-bold">@lang('content.login')</h3>
                    </div>
                    <!-- End Header -->
                    <div class="card-body pt-6 pb-4">
                        <!-- Form Group -->
                        <div class="form-group pb-1">
                            <div class="js-form-message js-focus-state border border-width-2 border-color-8 rounded-sm">
                                <label class="sr-only" for="signinSrEmail">@lang('content.email')</label>
                                <div class="input-group input-group-tranparent input-group-borderless input-group-radiusless">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="signinSrEmail" placeholder="@lang('content.email')" aria-label="Email Or Username" aria-describedby="signinEmail" required="" data-msg="Please enter a valid email address." data-error-class="u-has-error" data-success-class="u-has-success">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="signinEmail">
                                            <span class="far fa-envelope font-size-20"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Form Group -->
                        <!-- Form Group -->
                        <div class="form-group pb-1">
                            <div class="js-form-message js-focus-state border border-width-2 border-color-8 rounded-sm">
                                <label class="sr-only" for="signinSrPassword">@lang('content.password')</label>
                                <div class="input-group input-group-tranparent input-group-borderless input-group-radiusless">
                                    <input type="password" class="form-control" name="password" id="signinSrPassword" placeholder="@lang('content.password')" aria-label="Password" aria-describedby="signinPassword" required="" data-msg="Your password is invalid. Please try again." data-error-class="u-has-error" data-success-class="u-has-success">
                                        
                                </div>
                            </div>
                        </div>
                        <!-- End Form Group -->
                        <div class="mb-3 pb-1">
                            <button type="submit" class="btn btn-md btn-block btn-blue-1 rounded-xs font-weight-bold transition-3d-hover">@lang('content.login')</button>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <div class="custom-control custom-checkbox custom-control-inline">
                                <input type="checkbox" id="customCheckboxInline1" name="customCheckboxInline1" class="custom-control-input">
                                <label class="custom-control-label" for="customCheckboxInline1">@lang('content.remember_me')</label>
                            </div>
                            @if (Route::has('password.request'))
                            <a class="text-primary font-size-14" href="{{ route('password.request') }}"><u>@lang('content.forgot_password')?</u></a>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer p-0">

                        <div class="card-footer__bottom p-4 text-center font-size-14">
                            <span class="text-gray-1">@lang('content.have_account')?</span>
                            <a class="js-animation-link font-weight-bold" href="https://www.forsanway.com/ar/user-signup" data-target="#signup" data-link-group="idForm" data-animation-in="fadeIn">@lang('content.sign_up')</a>
                        </div>
                    </div>
                    </form>
                </div>
                <!-- End Login -->
        </div>
        </div>
        </div>
    </div>
</main>
@endsection
@section('front-additional-js')
<script src="https://unpkg.com/bootstrap-show-password@1.2.1/dist/bootstrap-show-password.min.js"></script>
<script>
    $('#signinSrPassword').password();
</script>
@endsection
