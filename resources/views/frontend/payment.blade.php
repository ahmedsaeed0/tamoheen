@extends('layouts.front.master')
@section('title')
Payment
@endsection
@section('front-additional-css')
<style>
    .text-start{
        text-align: start;
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
                        <h2 class="text-start">@lang('content.payment_form')</h2>
                        @if(session()->has('success'))
                            <span class="text-success text-center">{{ Session::get('success') }}</span>
                        @endif
                        @if(session()->has('error'))
                            <span class="text-danger text-center">{{ Session::get('error') }}</span>
                        @endif
                    </div>
                    <div class="pt-4 pb-5 px-5">
                         @if($user_amount!= null && $user_amount->total_amount > 0)
                            <h5 id="scroll-description" class="text-start font-size-21 font-weight-bold text-dark">
                                @lang('content.wallet_balance') :: SAR {{$user_amount->total_amount}}
                            </h5>
                            <input checked readonly style ="pointer-events: none;" type="checkbox" class="mb-4"> @lang('content.use_wallet_balance')
                        @endif
                        @if(empty($user_amount) || ($user_amount!= null && $tripbooking->price > $user_amount->total_amount))
                        <h5 id="scroll-description" class="text-start font-size-21 font-weight-bold text-dark mt-4 mb-4">
                            @lang('content.payment_type1')
                        </h5>

                        <ul class="nav nav-pills" role="tablist">
                            {{-- <li class="nav-item">
                              <a class="nav-link active" data-toggle="pill" href="#paytab">@lang('content.paytabs')</a>
                            </li> --}}
                            <li class="nav-item">
                              <a class="nav-link active bg-light" data-toggle="pill" href="#telr">
                                  
                              <img src="{{ asset('storage/visa-mada.png') }}"  height="50"/>
                                  </a>
                            </li>
                            <li class="nav-item active">
                              <a class="" data-toggle="pill" href="#stc">
                                  <img src="{{ asset('storage/stc-pay.png') }}"  style="height:70px;width:70px"/>
                              </a>
                            </li>
                        </ul>

                        <!-- Tab Content -->
                        <div class="tab-content">
                            <div class="tab-pane fade" id="paytab" role="tabpanel" aria-labelledby="pills-one-example2-tab">
                                    <div class="row justify-content-around">
                                        <div class="card">
                                            <div class="card-body">
                                                <a href="{{ url('paytab-payment/'.$tripbooking->id) }}">@lang('content.paytabs')</a>
                                            </div>
                                        </div>
                                    </div>

                                <div class="row">
                                    <div class="col-md-6 mx-auto">
                                        @if(app()->getLocale() == 'ur')
                                            <form class="js-validate pt-3" action="{{ url('ur/paytab-payment-submit') }}" method="POST">
                                        @elseif(app()->getLocale() == 'ar')
                                            <form class="js-validate pt-3" action="{{ url('ar/paytab-payment-submit') }}" method="POST">
                                        @else
                                            <form class="js-validate pt-3" action="{{ url('/paytab-payment-submit') }}" method="POST">
                                        @endif
                                            @csrf
                                            <div class="row">
                                                <!-- Input -->
                                                <div class="col-sm-12 mb-4">
                                                    <div class="js-form-message">

                                                        <input type="hidden" name="booking_id" value="{{ $tripbooking->id }}">
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
                            <div class="tab-pane fade " id="stc" role="tabpanel" aria-labelledby="pills-one-example2-tab">

                                <h3 class="text-center mb-2">@lang('content.pay_with_stc')</h3>


                                @if(app()->getLocale() == 'ur')
                                    <form class="js-validate pt-3" action="{{ url('ur/stc-payment-submit') }}" method="POST">
                                @elseif(app()->getLocale() == 'ar')
                                    <form class="js-validate pt-3" action="{{ url('ar/stc-payment-submit') }}" method="POST">
                                @else
                                    <form class="js-validate pt-3" action="{{ url('stc-payment-submit') }}" method="POST">
                                @endif

                                    @csrf
                                <div class="row pt-3">
                                    <div class="col-md-6 mx-auto">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label for="mobile">@lang('content.mobile')</label>
                                                    <input type="text" class="form-control" name="stc_mobile" placeholder="Enter your stc mobile number" id="mobile">
                                                </div>

                                                <input type="hidden" class="form-control" name="trip_booking_id" required value="{{ Crypt::encrypt($tripbooking->id) }}">
                                                <!-- End Input -->

                                                <div class="w-100"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mx-auto pt-3">
                                        <button type="submit" class="btn btn-primary w-100 rounded-sm transition-3d-hover font-size-16 font-weight-bold py-3">@lang('content.confirm_booking')</button>
                                    </div>
                                </div>
                                </form>
                            </div>
                            <div class="tab-pane fade show active" id="telr" role="tabpanel" aria-labelledby="pills-one-example2-tab">
                                <div class="row justify-content-around">
                                    <div class="col-md-6 mx-auto">
                                            <a class="btn btn-primary w-100 rounded-sm transition-3d-hover font-size-16 font-weight-bold py-3" href="{{ url('telr-trip-payment/'.$tripbooking->id) }}">
                                                @lang('content.paynow')
                            </a>
                                       
                                    </div>
                                </div>

                                 <div class="row">
                                    <div class="col-md-6 mx-auto">
                                        @if(app()->getLocale() == 'ur')
                                            <form class="js-validate pt-3" action="{{ url('ur/telr-trip-payment-submit') }}" method="POST">
                                        @elseif(app()->getLocale() == 'ar')
                                            <form class="js-validate pt-3" action="{{ url('ar/telr-trip-payment-submit') }}" method="POST">
                                        @else
                                            <form class="js-validate pt-3" action="{{ url('/telr-trip-payment-submit') }}" method="POST">
                                        @endif
                                            @csrf
                                            <div class="row">
                                                <!-- Input -->
                                                <div class="col-sm-12 mb-4">
                                                    <div class="js-form-message">

                                                        <input type="hidden" name="booking_id" value="{{ $tripbooking->id }}">
                                                        @if($result != null)
                                                        <input type="hidden" name="trx_id" value="{{ $result->trx_reference }}">
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="w-100"></div>

                                                <div class="col">
                                                    <!-- <button type="submit" class="btn btn-primary w-100 rounded-sm transition-3d-hover font-size-16 font-weight-bold py-3">@lang('content.confirm_booking')</button> -->
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div> <!-- start comment -->
                            </div>
                        </div>
                        @else
                            @if(app()->getLocale() == 'ar')
                                <form class="js-validate pt-3" action="{{ url('ar/paytab-payment-submit') }}" method="POST">
                            @else
                                <form class="js-validate pt-3" action="{{ url('/paytab-payment-submit') }}" method="POST">
                            @endif
                                @csrf
                                <div class="row">
                                    <!-- Input -->
                                    <div class="col-sm-12 mb-4">
                                        <div class="js-form-message">                                            
                                            <input type="hidden" name="booking_id" value="{{ $tripbooking->id }}">                                    
                                            <input type="hidden" name="trx_id" value="<?=rand(111111111,999999999)?>">                                        
                                        </div>
                                    </div>
                                    <div class="w-100"></div>

                                    <div class="col">
                                        <button type="submit" class="btn btn-primary w-100 rounded-sm transition-3d-hover font-size-16 font-weight-bold py-3">@lang('content.confirm_booking')</button>
                                    </div>
                                </div>
                            </form>
                        @endif
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
