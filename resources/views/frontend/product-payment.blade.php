@extends('layouts.front.master')
@section('title')
Payment
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
                        <h2>@lang('content.payment_form')</h2>
                        @if(session()->has('success'))
                            <span class="text-success text-center">{{ Session::get('success') }}</span>
                        @endif
                        @if(session()->has('error'))
                            <span class="text-danger text-center">{{ Session::get('error') }}</span>
                        @endif
                    </div>
                    <div class="pt-4 pb-5 px-5">
                        <h5 id="scroll-description" class="font-size-21 font-weight-bold text-dark mb-4">
                            @lang('content.payment_type')
                        </h5>

                        <ul class="nav nav-pills" role="tablist">
                            {{-- <li class="nav-item">
                              <a class="nav-link active" data-toggle="pill" href="#paytab">@lang('content.paytabs')</a>
                            </li> --}}
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="pill" href="#stc">@lang('content.stc')</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="pill" href="#telr">@lang('content.telr')</a>
                            </li>
                        </ul>

                        <!-- Tab Content -->
                        <div class="tab-content">
                            <div class="tab-pane fade show " id="paytab" role="tabpanel" aria-labelledby="pills-one-example2-tab">
                                    <div class="row justify-content-around">
                                        <div class="card">
                                            <div class="card-body">
                                                <a href="{{ url('product-paytab-payment/'.$order->id) }}">@lang('content.paytabs')</a>
                                            </div>
                                        </div>
                                    </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mx-auto">
                                        @if(app()->getLocale() == 'ur')
                                            <form class="js-validate pt-3" action="{{ url('ur/product-paytab-payment-submit') }}" method="POST">
                                        @elseif(app()->getLocale() == 'ar')
                                            <form class="js-validate pt-3" action="{{ url('ar/product-paytab-payment-submit') }}" method="POST">
                                        @else
                                            <form class="js-validate pt-3" action="{{ url('product-paytab-payment-submit') }}" method="POST">
                                        @endif
                                            @csrf
                                            <div class="row">
                                                <!-- Input -->
                                                <div class="col-sm-12 mb-4">
                                                    <div class="js-form-message">

                                                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                                                        @if($result != null)
                                                        <input type="hidden" name="trx_id" value="{{ $result->transaction_id }}">
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="w-100"></div>

                                                <div class="col">
                                                    <button type="submit" class="btn btn-primary w-100 rounded-sm transition-3d-hover font-size-16 font-weight-bold py-3">@lang('content.confirm_booking')</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade show active" id="stc" role="tabpanel" aria-labelledby="pills-one-example2-tab">
                                <h3 class="text-center mb-2">@lang('content.pay_with_stc')</h3>
                                @if(app()->getLocale() == 'ur')
                                    <form class="js-validate pt-3" action="{{ url('ur/product-stc-payment-submit') }}" method="POST">
                                @elseif(app()->getLocale() == 'ar')
                                    <form class="js-validate pt-3" action="{{ url('ar/product-stc-payment-submit') }}" method="POST">
                                @else
                                    <form class="js-validate pt-3" action="{{ url('product-stc-payment-submit') }}" method="POST">
                                @endif
                                
                                    @csrf
                                <div class="row pt-3">
                                    <div class="col-md-6 mx-auto">
                                        <div class="card">
                                            <div class="card-body">

                                                <div class="form-group">
                                                    <label for="mobile">@lang('content.mobile')</label>
                                                    <input type="text" class="form-control" name="stc_mobile" placeholder="@lang('content.enter_stc_mobile_number')" id="mobile">
                                                </div>

                                                <input type="hidden" class="form-control" name="ref_id" required value="{{ Crypt::encrypt($order->id) }}">
                                                <!-- End Input -->

                                                <div class="w-100"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mx-auto pt-3">
                                        <button type="submit" class="btn btn-primary w-100 rounded-sm transition-3d-hover font-size-16 font-weight-bold py-3">@lang('content.send_otp')</button>
                                    </div>
                                </div>
                                </form>
                            </div>
                            <div class="tab-pane fade show " id="telr" role="tabpanel" aria-labelledby="pills-one-example2-tab">
                                    <div class="row justify-content-around">
                                        <div class="card">
                                            <div class="card-body">
                                                <a href="{{ url('telr-product-payment/'.$order->id) }}">@lang('content.telr')</a>
                                            </div>
                                        </div>
                                    </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mx-auto">
                                        @if(app()->getLocale() == 'ur')
                                            <form class="js-validate pt-3" action="{{ url('ur/telr-product-payment-submit') }}" method="POST">
                                        @elseif(app()->getLocale() == 'ar')
                                            <form class="js-validate pt-3" action="{{ url('ar/telr-product-payment-submit') }}" method="POST">
                                        @else
                                            <form class="js-validate pt-3" action="{{ url('telr-product-payment-submit') }}" method="POST">
                                        @endif
                                            @csrf
                                            <div class="row">
                                                <!-- Input -->
                                                <div class="col-sm-12 mb-4">
                                                    <div class="js-form-message">

                                                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                                                        @if($result != null)
                                                        <input type="hidden" name="trx_id" value="{{ $result->trx_reference }}">
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="w-100"></div>

                                                <div class="col">
                                                    <button type="submit" class="btn btn-primary w-100 rounded-sm transition-3d-hover font-size-16 font-weight-bold py-3">@lang('content.confirm_booking')</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <!-- End Tab Content -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
@section('front-additional-js')
@endsection