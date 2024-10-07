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

<style>
    .text-start {

        text-align: start !important
    }

    .custom-error{
        width: 100%;
        margin-top: 0.25rem;
        font-size: 80%;
        color: #de4437;
    }
</style>

<link href="{{asset('front/hijri-date-picker-bootstrap/dist/css/bootstrap-datetimepicker.css')}}" rel="stylesheet" />

@endsection

@section('content')

@include('layouts.front.include.header1')

<main id="content">

    <div class="container">

        <h1 class="text-center">@lang('content.signup_panel')</h1>

        <div class="card rounded-xs">



            <!-- Signup -->

            <div id="signup" class="animated fadeIn">

                <!-- Header -->

                <div class="card-header text-center">
                    <!--<h3>fgrfgdfrgrtgertgrtge</h3>-->
                    <h3 class="h5 mb-0 font-weight-semi-bold">@lang('content.register')</h3>

                    @if (session('success'))

                    <div class="alert alert-success" role="alert">

                        {{ session('success') }}

                    </div>

                    @endif

                </div>

                @if ($errors->any())

                <div class="alert alert-danger">

                    <ul>

                        @foreach ($errors->all() as $error)

                        <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

                @endif

                <!-- End Header -->

                <div class="card-body pt-5 pb-4">

                    <ul class="nav nav-default nav-pills nav-white nav-justified nav-rounded-pill font-weight-medium px-6 pb-5" role="tablist">

                        <li style="border-radius: 1.25rem;border:1px solid #ebf0f7" class="nav-item">

                            <a class="nav-link active" id="pills-one-code-sample-tab" data-toggle="pill" href="#pills-one-code-sample" role="tab" aria-controls="pills-one-code-sample" aria-selected="true">@lang('content.normal_user')</a>

                        </li>

                        <li style="border-radius: 1.25rem;border:1px solid #ebf0f7" class="nav-item">

                            <a class="nav-link" id="pills-two-code-sample-tab" data-toggle="pill" href="#pills-two-code-sample" role="tab" aria-controls="pills-two-code-sample" aria-selected="false">@lang('content.partner_user')</a>

                        </li>

                    </ul>



                    <div class="tab-content">

                        <div class="tab-pane fade active show" id="pills-one-code-sample" role="tabpanel" aria-labelledby="pills-one-code-sample-tab">

                            @if(app()->getLocale() == 'ur')

                            <form id="UsersignupForm" class="js-validate" novalidate="novalidate" method="post" action="{{ url('ur/user-signup') }}" enctype="multipart/form-data">

                                @elseif(app()->getLocale() == 'ar')

                                <form id="UsersignupForm" class="js-validate" novalidate="novalidate" method="post" action="{{ url('ar/user-signup') }}" enctype="multipart/form-data">

                                    @else

                                    <form id="UsersignupForm" class="js-validate" novalidate="novalidate" method="post" action="{{ url('user-signup') }}" enctype="multipart/form-data">

                                        @endif

                                        @csrf

                                        <!-- Form Group -->

                                        <div class="form-group pb-1">

                                            <div class="js-form-message  js-focus-state  rounded-sm">

                                                <label class="" for="title">@lang('content.title')<span class="text-danger">*</span></label>

                                                <div class="input-group input-group-tranparent input-group-borderless border border-width-2 border-color-8 ">

                                                    <select class="form-control text-start" name="title" id="title" aria-label="Title" aria-describedby="name_title" required>

                                                        <option>@lang('content.select_title')</option>

                                                        <option value="1">@lang('content.mr')</option>

                                                        <option value="2">@lang('content.mrs')</option>

                                                    </select>

                                                    <div class="input-group-prepend">

                                                        <span class="input-group-text" id="name_title">

                                                            <span class=" font-size-20"></span>

                                                        </span>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                        <!-- End Form Group -->





                                        <!-- Form Group -->

                                        <div class="form-group pb-1">

                                            <div class="js-form-message text-start js-focus-state  rounded-sm">

                                                <label class="" for="name">@lang('content.full_name')<span class="text-danger">*</span></label>

                                                <div class="input-group input-group-tranparent input-group-borderless border border-width-2 border-color-8 input-group-radiusless">

                                                    <input type="text" class="form-control" name="name" id="name" placeholder="@lang('content.full_name')" aria-label="Full Name" aria-describedby="normalname" required="" data-msg-en="Required Field" data-msg-ar="حقل مطلوب" data-error-class="u-has-error" data-success-class="u-has-success">

                                                    <div class="input-group-append">

                                                        <span class="input-group-text" id="normalname">

                                                            <span class="flaticon- -1 font-size-20"></span>

                                                        </span>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                        <!-- End Form Group -->



                                        <!-- Form Group -->

                                        <div class="form-group pb-1">

                                            <div class="js-form-message text-start js-focus-state  rounded-sm">

                                                <label class="" for="signupSrEmail">@lang('content.email')<span class="text-danger">*</span></label>

                                                <div class="input-group input-group-tranparent input-group-borderless border border-width-2 border-color-8 input-group-radiusless">

                                                    <input type="email" class="form-control" name="email" id="signupSrEmail" placeholder="@lang('content.email')" aria-label="Email" aria-describedby="signupEmail1" required=""  data-msg-en="Please enter a valid email address." data-msg-ar=" يرجى إدخال عنوان بريد إلكتروني صالح. "   data-error-class="u-has-error" data-success-class="u-has-success">

                                                    <div class="input-group-append">

                                                        <span class="input-group-text" id="signupEmail1">

                                                            <span class="far fa-envelope font-size-20"></span>

                                                        </span>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                        <!-- End Form Group -->



                                        <!-- Form Group -->

                                        <div class="form-group pb-1">

                                            <div class="js-form-message text-start js-focus-state  rounded-sm">

                                                <label class="" for="mobile">@lang('content.mobile_lable')<span class="text-danger">*</span></label>

                                                <div class="input-group input-group-tranparent input-group-borderless border border-width-2 border-color-8 input-group-radiusless">

                                                    <input type="text" class="form-control" name="mobile" id="mobile" placeholder="@lang('content.mobile')" aria-label="Mobile" aria-describedby="mob" required="" data-msg-en="Required Field" data-msg-ar="حقل مطلوب" data-error-class="u-has-error" data-success-class="u-has-success">

                                                    <div class="input-group-prepend">

                                                        <span class="input-group-text" id="mob">

                                                            <span class="fas fa-mobile font-size-20"></span>

                                                        </span>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                        <!-- End Form Group -->



                                        <!-- Form Group -->

                                        <div class="form-group pb-1">

                                            <div class="js-form-message text-start js-focus-state  rounded-sm">

                                                <label class="" for="signupSrPassword">@lang('content.password_lable')<span class="text-danger">*</span></label>

                                                <div class="input-group input-group-tranparent input-group-borderless border border-width-2 border-color-8 input-group-radiusless">

                                                    <input type="password" class="form-control" name="password" id="signupSrPassword" placeholder="@lang('content.password')" aria-label="Password" aria-describedby="signupPassword1" required="" data-msg-en="Your password is invalid. Please try again." data-msg-ar=" كلمة المرور الخاصة بك غير صالحة. حاول مرة اخرى." data-error-class="u-has-error" data-success-class="u-has-success">

                                                    <div class="input-group-prepend">

                                                        <span class="input-group-text" id="signupPassword1">

                                                            <span class="far fa-eye-slash font-size-20"></span>

                                                        </span>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                        <!-- End Form Group -->

                                        <!-- Form Group -->

                                        <div class="form-group pb-1">

                                            <div class="js-form-message text-start js-focus-state  rounded-sm">

                                                <label class="" for="confirmPassword">@lang('content.confirm_password')<span class="text-danger">*</span></label>

                                                <div class="input-group input-group-tranparent input-group-borderless border border-width-2 border-color-8 input-group-radiusless">

                                                    <input type="password" class="form-control" name="password_confirmation" id="confirmPassword1" placeholder="@lang('content.confirm_password')" aria-label="Password" aria-describedby="confirmVPassword" required=""data-msg-en="Your password is invalid. Please try again." data-msg-ar=" كلمة المرور الخاصة بك غير صالحة. حاول مرة اخرى." data-error-class="u-has-error" data-success-class="u-has-success">

                                                    <div class="input-group-prepend">

                                                        <span class="input-group-text" id="confirmVPassword1">

                                                            <span class="far fa-eye-slash font-size-20"></span>

                                                        </span>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                        <!-- End Form Group -->

                                        <!-- Form Group -->

                                        <!--<div class="form-group pb-1">-->

                                        <!--    <div class="js-form-message text-start js-focus-state  rounded-sm">-->

                                        <!--        <label class="" for="identity_type">@lang('content.identity_type')<span class="text-danger">*</span></label>-->

                                        <!--        <div class="input-group input-group-tranparent input-group-borderless border border-width-2 border-color-8 input-group-radiusless">-->

                                        <!--            <select class="form-control" name="identity_type" id="identity_type" aria-label="Identity Type" aria-describedby="id_type">-->

                                        <!--                <option>@lang('content.select_identity_type')</option>-->

                                        <!--                <option value="1">@lang('content.nid')</option>-->

                                        <!--                <option value="2">@lang('content.passport')</option>-->

                                        <!--                <option value="3">@lang('content.iqma_number')</option>-->

                                        <!--            </select>-->

                                        <!--            <div class="input-group-prepend">-->

                                        <!--                <span class="input-group-text" id="id_type">-->

                                        <!--                    <span class="fas fa-id-badge font-size-20"></span>-->

                                        <!--                </span>-->

                                        <!--            </div>-->

                                        <!--        </div>-->

                                        <!--    </div>-->

                                        <!--</div>-->

                                        <!-- End Form Group -->

                                        <!-- Form Group -->

                                        <!--<div class="form-group pb-1">-->

                                        <!--    <div class="js-form-message text-start js-focus-state  rounded-sm">-->

                                        <!--        <label class="" for="identity_number">@lang('content.identity_number')<span class="text-danger">*</span></label>-->

                                        <!--        <div class="input-group input-group-tranparent input-group-borderless border border-width-2 border-color-8 input-group-radiusless">-->

                                        <!--            <input type="text" class="form-control" name="identity_number" id="identity_number" placeholder="@lang('content.identity_number')" aria-label="Identity Number">-->

                                        <!--            <div class="input-group-prepend">-->

                                        <!--                <span class="input-group-text" id="id_number">-->

                                        <!--                    <span class="fas fa-id-badge font-size-20"></span>-->

                                        <!--                </span>-->

                                        <!--            </div>-->

                                        <!--        </div>-->

                                        <!--    </div>-->

                                        <!--</div>-->

                                        <!-- End Form Group -->



                                        <!-- End Form Group -->

                                        <!--<div class="form-group pb-1">-->

                                        <!--    <div class="js-form-message text-start js-focus-state  rounded-sm">-->

                                        <!--        <label class="" for="user_image">@lang('content.user_photo')<span class="text-danger">*</span></label>-->

                                        <!--        <div class="input-group input-group-tranparent input-group-borderless border border-width-2 border-color-8 input-group-radiusless">-->

                                        <!--            <input type="file" class="form-control" name="user_image" id="user_image" placeholder="User Image" aria-label="User Image" aria-describedby="user_photo" required="" data-msg="Required Field" data-error-class="u-has-error" data-success-class="u-has-success" title="User Photo">-->

                                        <!--            <div class="input-group-prepend">-->

                                        <!--                <span class="input-group-text" id="user_photo">-->

                                        <!--                    <span class="fas fa-image font-size-20"></span>-->

                                        <!--                </span>-->

                                        <!--            </div>-->

                                        <!--        </div>-->

                                        <!--    </div>-->

                                        <!--</div>-->
                                        
                                        <!-- End Form Group -->

                                        <div class="d-flex justify-content-start mb-3">

                                            <div class="custom-control custom-checkbox custom-control-inline">

                                                <input type="checkbox" id="customCheckboxInline2" name="customCheckboxInline2" class="custom-control-input">

                                                <label class="custom-control-label" for="customCheckboxInline2">@lang('content.read_accept') <a href="{{ url($page->slug) }}">@lang('content.terms_and_privacy')</a></label>

                                            </div>

                                        </div>

                                         <!-- Google reCAPTCHA box -->
                                         {{-- <div id="RecaptchaField1"></div>
                                        <span id="captcha-error" class="invalid-feedback"></span> --}}

                                        <div class="" style="margin-top: 15px">

                                            <button type="submit" class="btn btn-md btn-block btn-blue-1 rounded-xs font-weight-bold transition-3d-hover">@lang('content.register')</button>

                                        </div>



                                    </form>

                        </div>

                        <div class="tab-pane fade" id="pills-two-code-sample" role="tabpanel" aria-labelledby="pills-two-code-sample-tab">

                            @if(app()->getLocale() == 'ur')

                            <form id="PartnersignupForm" class="js-validate" novalidate="novalidate" method="post" action="{{ url('ur/partner-signup') }}" enctype="multipart/form-data">

                                @elseif(app()->getLocale() == 'ar')

                                <form id="PartnersignupForm" class="js-validate" novalidate="novalidate" method="post" action="{{ url('ar/partner-signup') }}" enctype="multipart/form-data">

                                    @else

                                    <form id="PartnersignupForm" class="js-validate" novalidate="novalidate" method="post" action="{{ url('partner-signup') }}" enctype="multipart/form-data">

                                        @endif

                                        @csrf

                                        <!-- Form Group -->

                                        <div class="form-group pb-1">

                                            <div class="js-form-message text-start js-focus-state  rounded-sm">

                                                <label class="" for="title2">@lang('content.title')<span class="text-danger">*</span></label>

                                                <div class="input-group input-group-tranparent input-group-borderless border border-width-2 border-color-8 input-group-radiusless">

                                                    <select class="form-control" name="title" id="title2" aria-label="Title" aria-describedby="name_title" required>

                                                        <option>@lang('content.select_title')</option>

                                                        <option value="1">@lang('content.mr')</option>

                                                        <option value="2">@lang('content.mrs')</option>

                                                    </select>

                                                    <div class="input-group-prepend">

                                                        <span class="input-group-text" id="name_title">

                                                            <span class=" font-size-20"></span>

                                                        </span>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                        <!-- End Form Group -->





                                        <!-- Form Group -->

                                        <div class="form-group pb-1">

                                            <div class="js-form-message text-start js-focus-state  rounded-sm">

                                                <label class="" for="name2">@lang('content.full_name')<span class="text-danger">*</span></label>

                                                <div class="input-group input-group-tranparent input-group-borderless border border-width-2 border-color-8 input-group-radiusless">

                                                    <input type="text" class="form-control" name="name" id="name2" placeholder="@lang('content.full_name')" aria-label="Full Name" aria-describedby="normalname" required="" data-msg-en="Please enter a valid name" data-msg-ar="رجاء ادخل اسما صحيحا"data-error-class="u-has-error" data-success-class="u-has-success">

                                                    <div class="input-group-append">

                                                        <span class="input-group-text" id="normalname">

                                                            <span class=" font-size-20"></span>

                                                        </span>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                        <!-- End Form Group -->



                                        <!-- Form Group -->

                                        <div class="form-group pb-1">

                                            <div class="js-form-message text-start js-focus-state  rounded-sm">

                                                <label class="" for="nickname">@lang('content.nickname')<span class="text-danger">*</span></label>

                                                <div class="input-group input-group-tranparent input-group-borderless border border-width-2 border-color-8 input-group-radiusless">

                                                    <input type="text" class="form-control" name="nickname" id="nickname" placeholder="@lang('content.nickname')" aria-label="Nickname" aria-describedby="normalname" required="" data-msg-en="Please enter a valid nickname." data-msg-ar="الرجاء إدخال لقب صالح." data-error-class="u-has-error" data-success-class="u-has-success">

                                                    <div class="input-group-append">

                                                        <span class="input-group-text" id="normalname">

                                                            <span class=" font-size-20"></span>

                                                        </span>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                        <!-- End Form Group -->



                                        <!-- Form Group -->

                                        <div class="form-group pb-1">

                                            <div class="js-form-message text-start js-focus-state  rounded-sm">

                                                <label class="" for="signupSrEmail2">@lang('content.email')<span class="text-danger">*</span></label>

                                                <div class="input-group input-group-tranparent input-group-borderless border border-width-2 border-color-8 input-group-radiusless">

                                                    <input type="email" class="form-control" name="email" id="signupSrEmail2" placeholder="@lang('content.email')" aria-label="Email" aria-describedby="signupEmail2" required="" data-msg-en="Please enter a valid email address." data-msg-ar="يرجى إدخال عنوان بريد إلكتروني صالح." data-error-class="u-has-error" data-success-class="u-has-success">

                                                    <div class="input-group-append">

                                                        <span class="input-group-text" id="signupEmail2">

                                                            <span class="far fa-envelope font-size-20"></span>

                                                        </span>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                        <!-- End Form Group -->



                                        <!-- Form Group -->

                                        <div class="form-group pb-1">

                                            <div class="js-form-message text-start js-focus-state  rounded-sm">

                                                <label class="" for="mobile2">@lang('content.mobile_lable')<span class="text-danger">*</span></label>

                                                <div class="input-group input-group-tranparent input-group-borderless border border-width-2 border-color-8 input-group-radiusless">
                                                <div class="input-group-prepend">
                                                        <span class="input-group-text" id="mob">+966</span>
                                                    </div>
                                                    <input type="text" class="form-control" name="mobile" id="mobile2" placeholder="@lang('content.mobile')" oninput="validateInput(this)" maxlength="10" aria-label="Mobile" aria-describedby="mob" required="" data-msg-en="Required Field" data-msg-ar="حقل مطلوب" data-error-class="u-has-error" data-success-class="u-has-success">

                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="mob">
                                                            <span class="fas fa-mobile font-size-20"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                                <span id="mobile-error" class="invalid-feedback">Test</span>
                                            </div>

                                        </div>

                                        <!-- End Form Group -->



                                        <!-- Form Group -->

                                        <div class="form-group pb-1">

                                            <div class="js-form-message text-start js-focus-state  rounded-sm">

                                                <label class="" for="signupSrPassword2">@lang('content.password_lable')<span class="text-danger">*</span></label>

                                                <div class="input-group input-group-tranparent input-group-borderless border border-width-2 border-color-8 input-group-radiusless">

                                                    <input type="password" class="form-control" name="password" id="signupSrPassword2" placeholder="@lang('content.password')" aria-label="Password" aria-describedby="signupPassword" required="" data-msg-en="Your password is invalid. Please try again." data-msg-ar="كلمة المرور الخاصة بك غير صالحة. حاول مرة اخرى. "data-error-class="u-has-error" data-success-class="u-has-success">

                                                    <div class="input-group-prepend">

                                                        <span class="input-group-text" id="signupPassword">

                                                            <span class="fas fa-eye-slash font-size-20"></span>

                                                        </span>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                        <!-- End Form Group -->

                                        <!-- Form Group -->

                                        <div class="form-group pb-1">

                                            <div class="js-form-message text-start js-focus-state  rounded-sm">

                                                <label class="" for="confirmPassword">@lang('content.confirm_password')<span class="text-danger">*</span></label>

                                                <div class="input-group input-group-tranparent input-group-borderless border border-width-2 border-color-8 input-group-radiusless">

                                                    <input type="password" class="form-control" name="password_confirmation" id="confirmPassword" placeholder="@lang('content.confirm_password')" aria-label="Password" aria-describedby="confirmVPassword" required="" data-msg-en="Your password is invalid. Please try again." data-msg-ar="كلمة المرور الخاصة بك غير صالحة. حاول مرة اخرى. " data-error-class="u-has-error" data-success-class="u-has-success">

                                                    <div class="input-group-prepend">

                                                        <span class="input-group-text" id="confirmVPassword">

                                                            <span class="fas fa-eye-slash font-size-20"></span>

                                                        </span>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                        <!-- End Form Group -->

                                        <!-- <div class="form-group pb-1">

                                            <div class="js-form-message text-start js-focus-state  rounded-sm">

                                                <label class="" for="confirmPassword">Brand Name<span class="text-danger">*</span></label>

                                                <div class="input-group input-group-tranparent input-group-borderless border border-width-2 border-color-8 input-group-radiusless">

                                                    <input type="text" class="form-control" name="brand_name" id="brandName" placeholder="Brand Name" aria-label="Password" aria-describedby="" required="" data-msg="Your brand name is invalid. Please try again." data-error-class="u-has-error" data-success-class="u-has-success">

                                                    <div class="input-group-prepend">

                                                        <span class="input-group-text" id="confirmVPassword">

                                                            <span class="fas fa-eye-slash font-size-20"></span>

                                                        </span>

                                                    </div>

                                                </div>

                                            </div>

                                        </div> -->

                                        <!-- Form Group -->

                                        <div class="form-group pb-1">

                                            <div class="js-form-message text-start js-focus-state  rounded-sm">

                                                <label class="" for="identity_type2">@lang('content.identity_type')<span class="text-danger">*</span></label>

                                                <div class="input-group input-group-tranparent input-group-borderless border border-width-2 border-color-8 input-group-radiusless">

                                                    <select class="form-control" name="identity_type" id="identity_type2" aria-label="Identity Type" aria-describedby="id_type" required>

                                                        <option>@lang('content.select_identity_type')</option>

                                                        <option value="1">@lang('content.nid')</option>

                                                        <option value="2">@lang('content.passport')</option>

                                                        <option value="3">@lang('content.iqma_number')</option>

                                                    </select>

                                                    <div class="input-group-prepend">

                                                        <span class="input-group-text" id="id_type">

                                                            <span class="fas fa-id-badge font-size-20"></span>

                                                        </span>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                        <!-- End Form Group -->

                                        <!-- Form Group -->

                                        <div class="form-group pb-1">

                                            <div class="js-form-message text-start js-focus-state  rounded-sm">

                                                <label class="" for="identity_number2">@lang('content.identity_number')<span class="text-danger">*</span></label>

                                                <div class="input-group input-group-tranparent input-group-borderless border border-width-2 border-color-8 input-group-radiusless">

                                                    <input type="text" class="form-control" name="identity_number" id="identity_number2" placeholder="@lang('content.identity_number')" aria-label="Identity Number" aria-describedby="id_number" required="" data-msg-en="Required Field" data-msg-ar="حقل مطلوب" data-error-class="u-has-error" data-success-class="u-has-success" maxlength="10" pattern="\d{10}">

                                                    <div class="input-group-prepend">

                                                        <span class="input-group-text" id="id_number">

                                                            <span class="fas fa-id-badge font-size-20"></span>

                                                        </span>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                        <!-- End Form Group -->

                                        <!-- End Form Group -->

                                        <div class="form-group pb-1">

                                            <div class="js-form-message text-start js-focus-state  rounded-sm">

                                                <label class="" for="user_image2">@lang('content.user_photo')<span class="text-danger">*</span></label>

                                                <div class="input-group input-group-tranparent input-group-borderless border border-width-2 border-color-8 input-group-radiusless">

                                                    <input type="file" class="form-control" name="user_image" id="user_image2" placeholder="User Image" aria-label="User Image" aria-describedby="user_photo" required="" data-msg-en="Required Field" data-msg-ar="حقل مطلوب" data-error-class="u-has-error" data-success-class="u-has-success" title="User Photo">

                                                    <div class="input-group-prepend">

                                                        <span class="input-group-text" id="user_photo">

                                                            <span class="fas fa-image font-size-20"></span>

                                                        </span>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                        <!-- End Form Group -->

                                        <!-- Form Group -->

                                        <div class="form-group pb-1">

                                            <div class="js-form-message text-start js-focus-state  rounded-sm">

                                                <label class="" for="address">@lang('content.address')<span class="text-danger">*</span></label>

                                                <div class="input-group input-group-tranparent input-group-borderless border border-width-2 border-color-8 input-group-radiusless">

                                                    <input type="text" class="form-control" name="address" id="address" placeholder="@lang('content.address')" aria-label="Address" aria-describedby="part_addr" required="" data-msg-en="Required Field" data-msg-ar="حقل مطلوب" data-error-class="u-has-error" data-success-class="u-has-success">

                                                    <div class="input-group-prepend">

                                                        <span class="input-group-text" id="part_addr">

                                                            <span class="fas fa-address-card font-size-20"></span>

                                                        </span>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                        <!-- End Form Group -->

                                        <div class="form-group pb-1" style="display: none;">

                                            <div class="js-form-message text-start js-focus-state  rounded-sm">

                                                <label class="" for="license_number">@lang('content.license_number')<span class="text-danger">*</span></label>

                                                <div class="input-group input-group-tranparent input-group-borderless border border-width-2 border-color-8 input-group-radiusless">

                                                    <input type="text" class="form-control" name="license_number" id="license_number" placeholder="@lang('content.license_number')" aria-label="License Number" aria-describedby="license_no" data-error-class="u-has-error" data-success-class="u-has-success"data-msg-en="Required Field" data-msg-ar="حقل مطلوب">

                                                    <div class="input-group-prepend">

                                                        <span class="input-group-text" id="license_no">

                                                            <span class="fas fa-id-badge font-size-20"></span>

                                                        </span>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                        <!-- End Form Group -->

            
                                        <div class="form-group pb-1" id="hijri">

                                            <div class="js-form-message text-start js-focus-state  rounded-sm">

                                                <label class="" for="date_of_birth_hijri">@lang('content.date_of_birth_hijri')</label>

                                                <div class="input-group input-group-tranparent input-group-borderless border border-width-2 border-color-8 input-group-radiusless">

                                                    <input type="text" class="form-control hijri-date-input" name="date_of_birth_hijri" id="date_of_birth_hijri" placeholder="@lang('content.date_of_birth_hijri')" aria-label="Date Of Birth Hijri" aria-describedby="dob_hijri" required="" data-msg-en="Required Field" data-msg-ar="حقل مطلوب"data-error-class="u-has-error" data-success-class="u-has-success">
                                                    
                                                    <div class="input-group-prepend">

                                                        <span class="input-group-text" id="dob_hijri">

                                                            <span class="fas fa-id-badge font-size-20"></span>

                                                        </span>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                        <!-- End Form Group -->



                                        <div class="form-group pb-1" id="regoin">

                                            <div class="js-form-message text-start js-focus-state  rounded-sm">

                                                <label class="" for="date_of_birth_gregorian">@lang('content.date_of_birth_gregorian')</label>

                                                <div class="input-group input-group-tranparent input-group-borderless border border-width-2 border-color-8 input-group-radiusless">

                                                    <input type="date" class="form-control" name="date_of_birth_gregorian" id="date_of_birth_gregorian" placeholder="@lang('content.date_of_birth_gregorian')" aria-label="Date Of Birth Gregorian" aria-describedby="dob_gregorian" required="" data-msg-en="Required Field" data-msg-ar="حقل مطلوب" data-error-class="u-has-error" data-success-class="u-has-success">
                                                    
                                                    <div class="input-group-prepend">

                                                        <span class="input-group-text" id="dob_gregorian">

                                                            <span class="fas fa-id-badge font-size-20"></span>

                                                        </span>

                                                    </div>

                                                </div>
                                    
                                            </div>
                                        <span class="text-danger custom-error"></span>
                                        </div>

                                        <!-- End Form Group -->

                                        <!-- End Form Group -->

                                        <div class="form-group pb-1" style="display: none;">

                                            <div class="js-form-message text-start js-focus-state  rounded-sm">

                                                <label class="" for="license_file">@lang('content.license_file')<span class="text-danger">*</span></label>

                                                <div class="input-group input-group-tranparent input-group-borderless border border-width-2 border-color-8 input-group-radiusless">

                                                    <input type="file" class="form-control" name="license_file" id="license_file" placeholder="License File" aria-label="License File" aria-describedby="license_photo" data-msg-en="Required Field" data-msg-ar="حقل مطلوب"data-error-class="u-has-error" data-success-class="u-has-success" title="License File">

                                                    <div class="input-group-prepend">

                                                        <span class="input-group-text" id="license_photo">

                                                            <span class="fas fa-file-upload font-size-20"></span>

                                                        </span>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>


                                        <div class="form-group pb-1">
                                            <div class="js-form-message text-start js-focus-state rounded-sm">
                                                <label for="referral_code">Referral Code</label>
                                                <div class="input-group input-group-transparent input-group-borderless border border-width-2 border-color-8 input-group-radiusless">
                                                <input type="text" class="form-control" name="referral_code" id="referral_code" placeholder="referral code" aria-label="Referral Code" aria-describedby="referral_code_msg" data-msg-en="Optional Field" data-msg-ar="حقل اختياري" data-error-class="u-has-error" data-success-class="u-has-success">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="referral_code_msg">
                                                            <span class="fas fa-user-friends font-size-20"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <!-- End Form Group -->

                                        <div class="d-flex justify-content-start mb-3">

                                            <div class="custom-control custom-checkbox custom-control-inline">

                                                <input type="checkbox" id="customCheckboxInline1" name="customCheckboxInline1" class="custom-control-input">

                                                <label class="custom-control-label" for="customCheckboxInline1">@lang('content.read_accept') <a href="{{ url($page->slug) }}">@lang('content.terms_and_privacy')</a></label>
                                                    
                                            </div>

                                        </div>
                                     <span class="text-danger">@lang('footer.alert')</span>

                                        <!-- Google reCAPTCHA box -->
                                        {{-- <div id="RecaptchaField2"></div>
                                        <span id="partner-captcha-error" class="invalid-feedback"></span> --}}
                                        <div class="" style="margin-top: 15px">
                                        
                                            <button type="submit" class="btn btn-md btn-block btn-blue-1 rounded-xs font-weight-bold transition-3d-hover">@lang('content.register')</button>

                                        </div>
                                        

                                    </form>



                        </div>

                    </div>

                </div>

            </div>

            </form>

            <!-- End Signup -->

        </div>

    </div>

</main>

@endsection

@section('front-additional-js')

<script src="{{asset('front/hijri-date-picker-bootstrap/dist/js/bootstrap-hijri-datetimepicker.js')}}"></script>
<script src="https://www.google.com/recaptcha/api.js?onload=CaptchaCallback&render=explicit" async defer></script>
<script type="text/javascript">
    var CaptchaCallback = function() {
        grecaptcha.render('RecaptchaField1', {'sitekey' : '6LddvJ4pAAAAAD9UGkrsOdi-ea2i5431biQdCqLj'});
        grecaptcha.render('RecaptchaField2', {'sitekey' : '6Lda254pAAAAAN3DNxTp2x9cKxWnWOXwdjP5RDXE'});
    };
</script>
<script>



$(document).ready(function() {
    $('form').on('submit', function(event) {
        if ($('#date_of_birth_hijri').val() === '' && $('#date_of_birth_gregorian').val() === '') {
            $('.custom-error').text('Please provide either Hijri or Gregorian date of birth.');
            event.preventDefault();
        }else{
            $('.custom-error').text('');
        }
    });
});

</script>
<script>
    $(".hijri-date-input").hijriDatePicker({



        // timezone

        timeZone: 'Etc/UTC',



        // Date format. See moment.js docs for valid formats.

        format: 'YYYY/MM/DD',

        hijriFormat: 'iYYYY/iMM/iDD',

        hijriDayViewHeaderFormat: 'iMMMM iYYYY',



        // Changes the heading of the datepicker when in "days" view.

        dayViewHeaderFormat: 'MMMM YYYY',



        // Allows for several input formats to be valid. 

        extraFormats: false,



        // Number of minutes the up/down arrow's will move the minutes value in the time picker

        stepping: 1,



        // Prevents date/time selections before this date

        minDate: '1950/01/01',



        // Prevents date/time selections after this date

        maxDate: '2070/01/01',



        // On show, will set the picker to the current date/time

        useCurrent: true,



        // Using a Bootstraps collapse to switch between date/time pickers.

        collapse: true,



        // See moment.js for valid locales.

        locale: 'ar-SA',



        // Sets the picker default date/time. 

        defaultDate: false,



        // Disables selection of dates in the array, e.g. holidays

        disabledDates: false,



        // Disables selection of dates NOT in the array, e.g. holidays

        enabledDates: false,



        // Change the default icons for the pickers functions.

        icons: {

            time: 'fa fa-clock text-primary',

            date: 'glyphicon glyphicon-calendar',

            up: 'fa fa-chevron-up text-primary',

            down: 'fa fa-chevron-down text-primary',

            previous: '<<',

            next: '>>',

            today: 'اليوم',

            clear: 'مسح',

            close: 'اغلاق'

        },



        // custom tooltip text

        tooltips: {

            today: 'Go to today',

            clear: 'Clear selection',

            close: 'Close the picker',

            selectMonth: 'Select Month',

            prevMonth: 'Previous Month',

            nextMonth: 'Next Month',

            selectYear: 'Select Year',

            prevYear: 'Previous Year',

            nextYear: 'Next Year',

            selectDecade: 'Select Decade',

            prevDecade: 'Previous Decade',

            nextDecade: 'Next Decade',

            prevCentury: 'Previous Century',

            nextCentury: 'Next Century',

            pickHour: 'Pick Hour',

            incrementHour: 'Increment Hour',

            decrementHour: 'Decrement Hour',

            pickMinute: 'Pick Minute',

            incrementMinute: 'Increment Minute',

            decrementMinute: 'Decrement Minute',

            pickSecond: 'Pick Second',

            incrementSecond: 'Increment Second',

            decrementSecond: 'Decrement Second',

            togglePeriod: 'Toggle Period',

            selectTime: 'Select Time'

        },



        // Defines if moment should use scrict date parsing when considering a date to be valid

        useStrict: false,



        // Shows the picker side by side when using the time and date together

        sideBySide: false,



        // Disables the section of days of the week, e.g. weekends.

        daysOfWeekDisabled: [],



        // Shows the week of the year to the left of first day of the week

        calendarWeeks: false,



        // The default view to display when the picker is shown

        // Accepts: 'years','months','days'

        viewMode: 'days',



        // Changes the placement of the icon toolbar

        toolbarPlacement: 'default',



        // Show the "Today" button in the icon toolbar

        showTodayButton: false,



        // Show the "Clear" button in the icon toolbar

        showClear: false,



        // Show the "Close" button in the icon toolbar

        showClose: false,



        // On picker show, places the widget at the identifier (string) or jQuery object if the element has css position: 'relative'

        widgetPositioning: {

            horizontal: 'auto',

            vertical: 'auto'

        },



        // On picker show, places the widget at the identifier (string) or jQuery object **if** the element has css `position: 'relative'`

        widgetParent: null,



        // Allow date picker show event to fire even when the associated input element has the `readonly="readonly"`property.

        ignoreReadonly: false,



        // Will cause the date picker to stay open after selecting a date if no time components are being used

        keepOpen: false,



        // If `false`, the textbox will not be given focus when the picker is shown.

        focusOnShow: true,



        // Will display the picker inline without the need of a input field. This will also hide borders and shadows.

        inline: false,



        // Will cause the date picker to **not** revert or overwrite invalid dates.

        keepInvalid: false,



        // CSS selector

        datepickerInput: '.datepickerinput',



        // shows switcher

        showSwitcher: true,



        // Debug mode

        debug: false,



        // If `true`, the picker will show on textbox focus and icon click when used in a button group.

        allowInputToggle: false,



        // Must be in 24 hour format. Will allow or disallow hour selections (much like `disabledTimeIntervals`) but will affect all days.

        disabledTimeIntervals: false,



        // Disable/enable hours

        disabledHours: false,

        enabledHours: false,



        // This will change the `viewDate` without changing or setting the selected date.

        viewDate: false,



        // Use hijri date

        hijri: true,



        // Enable/disable RTL mode

        isRTL: true



    });





    // $("#hijri").hide();

    $("#regoin").show();

    // $(document).on("change", "#identity_type2", function() {

    //     var identity_type2 = $(this).val();

    //     //console.log(identity_type2);

    //     if (identity_type2 == 1) {

    //         $("#hijri").show();

    //         $("#regoin").hide();

    //     } else {

    //         $("#hijri").hide();

    //         $("#regoin").show();

    //     }

    // })
</script>
<script>
    // function enableUserRecaptcha() {
    //     document.getElementById("userCaptcha").style.display = "block";
    //     var partnerCaptchaDiv = document.getElementById("partnerCaptcha");
    //     if (partnerCaptchaDiv) {
    //         partnerCaptchaDiv.remove();
    //     }
    // }

    // function enablePartnerRecaptcha() {
    //     document.getElementById("partnerCaptcha").style.display = "block";
    //     var userCaptchaDiv = document.getElementById("userCaptcha");
    //     if (userCaptchaDiv) {
    //         userCaptchaDiv.remove();
    //     }
    // }

    
    function validateInput(input) {
        const inputValue = input.value.trim();
        if (!/^\d*$/.test(inputValue)) {
            document.getElementById('mobile-error').textContent = "Only integer values allowed";
            input.value = inputValue.replace(/\D/g, '');
        } else {
            document.getElementById('mobile-error').textContent = "";
        }
    }
</script>
<script>
    function validateRecaptcha(event) {
        // var response = grecaptcha.getResponse();
        var response = grecaptcha.getResponse(0);
        var errorSpan = document.getElementById('captcha-error');
        if (response.length === 0) {
            event.preventDefault();
            errorSpan.textContent = 'Please check the reCAPTCHA checkbox.';
            errorSpan.style.display = 'block';
        } else {
            errorSpan.textContent = '';
        }
    }

 function validatePartnerRecaptcha(event) {
    var response = grecaptcha.getResponse(1);
    var errorSpan = document.getElementById('partner-captcha-error');
    var lang = document.documentElement.lang; // الحصول على لغة الصفحة الحالية

    if (response.length === 0) {
        event.preventDefault();
        
        if (lang === 'ar') {
            errorSpan.textContent = 'يرجى التحقق من خانة reCAPTCHA.';
        } else {
            errorSpan.textContent = 'Please check the reCAPTCHA checkbox.';
        }

        errorSpan.style.display = 'block';
    } else {
        errorSpan.textContent = '';
    }
}

    document.addEventListener('DOMContentLoaded', function() {
        var userForm = document.getElementById('UsersignupForm');
        if (userForm) {
            userForm.addEventListener('submit', function(event) {
                validateRecaptcha(event);
            });
        }

        var partnerForm = document.getElementById('PartnersignupForm');
        if (partnerForm) {
            partnerForm.addEventListener('submit', function(event) {
                validatePartnerRecaptcha(event);
            });
        }
    });
    document.addEventListener('DOMContentLoaded', function() {
    var lang = document.documentElement.lang; // الحصول على لغة الصفحة الحالية
    var formFields = document.querySelectorAll('.form-control');
    
    formFields.forEach(function(field) {
        if (lang === 'ar') {
            field.setAttribute('data-msg', field.getAttribute('data-msg-ar'));
        } else {
            field.setAttribute('data-msg', field.getAttribute('data-msg-en'));
        }
    });
});

</script>

@endsection