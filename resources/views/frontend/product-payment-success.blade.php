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
                        <h2>@lang('content.payment_info')</h2>
                    </div>
                    <div class="pt-4 pb-5 px-5">
                        <h3 id="scroll-description" class="font-size-21 font-weight-bold text-success mb-4 text-center">
                           @lang('content.payment_succ')
                        </h3>
                        <!-- Tab Content -->
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="paytab" role="tabpanel" aria-labelledby="pills-one-example2-tab">
                                    <div class="row justify-content-around">
                                        <div class="card">
                                            <div class="card-body">
                                               <h3>@lang('content.order_id'): {{ $order->id }}</h3>
                                               <p><b>@lang('content.estimate_time'):</b> {{ $order->estimated_time }}</p>
                                            </div>
                                        </div>
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