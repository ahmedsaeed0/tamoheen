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
                    </div>
                    <div class="pt-4 pb-5 px-5">
                        <!-- Tab Content -->
                        <div class="tab-content">
                            
                            <div class="tab-pane fade show active" id="stc" role="tabpanel" aria-labelledby="pills-one-example2-tab">
                                <h3 class="text-center mb-2">@lang('content.pay_with_stc')</h3>

                                @if($errors->has())
                                    @foreach ($errors->all() as $error)
                                        <div>{{ $error }}</div>
                                    @endforeach
                                @endif

                                @if(app()->getLocale() == 'ur')
                                    <form class="js-validate pt-3" action="{{ url('ur/direct-stc-trip-payment-confirm') }}" method="POST">
                                @elseif(app()->getLocale() == 'ar')
                                    <form class="js-validate pt-3" action="{{ url('ar/direct-stc-trip-payment-confirm') }}" method="POST">
                                @else
                                    <form class="js-validate pt-3" action="{{ url('direct-stc-trip-payment-confirm') }}" method="POST">
                                @endif
                                    @csrf
                                <div class="row pt-3">
                                    <div class="col-md-6 mx-auto">
                                        <div class="card">
                                            <div class="card-body">

                                                <div class="form-group">
                                                    <label for="mobile">@lang('content.otp_value')</label>
                                                    <input type="number" class="form-control" name="otp_value" placeholder="@lang('content.otp_value')" id="mobile">
                                                </div>

                                                {{-- <div class="form-group">
                                                    <label for="mobile">TokenRef:</label> --}}
                                                    <input type="hidden" class="form-control" name="token_ref" placeholder="Enter Token Reference Number" id="mobile" value="{{ Crypt::encrypt($trip_booking->id) }}">
                                                {{-- </div> --}}

                                                <input type="hidden" class="form-control" name="trip_booking_id" required value="{{ Crypt::encrypt($trip_booking->id) }}">

                                                <input type="hidden" name="OtpReference" value="{{ $final_response->DirectPaymentAuthorizeResponseMessage->OtpReference }}">
                                                <input type="hidden" name="StcPayPmtReference" value="{{ $final_response->DirectPaymentAuthorizeResponseMessage->STCPayPmtReference }}">
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