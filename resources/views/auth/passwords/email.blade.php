@extends('layouts.front.master')
@section('title')
Reset Password
@endsection
@section('front-additional-css')

@endsection
@section('content')
@include('layouts.front.include.header1')
<main id="content">
    <div class="container">
        
        <div class="row">
            <div class="col-md-3 col-sm-12">
            </div>
            <div class="col-md-6 col-sm-12">
                <h1 class="text-center">{{ __('Reset Password') }}</h1>
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="card rounded-xs">
                    <!-- Login -->
                    <div id="login" class="animated fadeIn" >
                        <form class="js-validate" novalidate="novalidate" method="post" action="{{ route('password.email') }}">
                        @csrf
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
                            <!-- End Form Group -->
                            <div class="mb-3 pb-1">
                                <button type="submit" class="btn btn-md btn-block btn-blue-1 rounded-xs font-weight-bold transition-3d-hover">{{ __('Send Password Reset Link') }}</button>
                            </div>
                        </div>
                        </form>
                    </div>
                    <!-- End Login -->
                </div>
            </div>
            <div class="col-md-3 col-sm-12">
            </div>
        </div>
            
    </div>
</main>
@endsection
@section('front-additional-js')

@endsection
