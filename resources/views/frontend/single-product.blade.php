@extends('layouts.front.master')
@section('title')
{{ $product->name }}
@endsection
@section('front-additional-css')
@endsection
@section('content')
@include('layouts.front.include.header1')
<main id="content">
<!-- Breadcrumb -->
<div class="container">
    <nav class="py-3" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-no-gutter mb-0 flex-nowrap flex-xl-wrap overflow-auto overflow-xl-visble">
            <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1"><a href="#">@lang('content.product')</a></li>
            @if(app()->getLocale() == 'ur')
                <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1 active" aria-current="page">{{ $product->name_urdu }}</li>
            @elseif(app()->getLocale() == 'ar')
                <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1 active" aria-current="page">{{ $product->name_arabic }}</li>
            @else

                <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1 active" aria-current="page">{{ $product->name }}</li>
            @endif
        </ol>
    </nav>
</div>
<!-- End Breadcrumb -->

<div class="container">
    <div class="row">
        <div class="col-lg-3 col-xl-3">
            <img class="img-fluid w-100" src="{{ asset('storage/'.$product->image->url) }}" alt="Image">
        </div>
        <div class="col-lg-6 col-xl-6">
            <div class="d-block d-md-flex flex-center-between align-items-start">
                <div class="mb-1">
                    <div class="mb-2 mb-md-0">
                        @if(app()->getLocale() == 'ur')
                            <h4 class="font-size-23 font-weight-bold mb-1 mr-3">{{ $product->name_urdu }}</h4>

                        @elseif(app()->getLocale() == 'ar')
                            <h4 class="font-size-23 font-weight-bold mb-1 mr-3">{{ $product->name_arabic }}</h4>

                        @else
                            <h4 class="font-size-23 font-weight-bold mb-1 mr-3">{{ $product->name }}</h4>

                        @endif
                    </div>
                    {{-- <div class="d-block d-xl-flex flex-horizontal-center">
                        <div class="d-block d-md-flex flex-horizontal-center font-size-14 text-gray-1 mb-2 mb-xl-0">
                            <i class="icon flaticon-placeholder mr-2 font-size-20"></i> 
                        </div>
                        <div class="mr-4 mb-2 mb-md-0 flex-horizontal-center">
                            <div class="ml-xl-3 font-size-10 letter-spacing-2">
                                <span class="d-block green-lighter ml-1">
                                    <span class="fas fa-star"></span>
                                    <span class="fas fa-star"></span>
                                    <span class="fas fa-star"></span>
                                    <span class="fas fa-star"></span>
                                    <span class="fas fa-star"></span>
                                </span>
                            </div>
                            <span class="font-size-14 text-gray-1 ml-2">(1,186 Reviews)</span>
                        </div>
                    </div> --}}
                </div>
                <ul class="list-group list-group-borderless list-group-horizontal custom-social-share">
                    <li class="list-group-item px-1">
                        <a href="#" class="height-45 width-45 border rounded border-width-2 flex-content-center">
                            <i class="flaticon-like font-size-18 text-dark"></i>
                        </a>
                    </li>
                    <li class="list-group-item px-1">
                        <a href="#" class="height-45 width-45 border rounded border-width-2 flex-content-center">
                            <i class="flaticon-share font-size-18 text-dark"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="py-4 border-top border-bottom mb-4">
                <ul class="list-group list-group-borderless list-group-horizontal row">
                    <li class="col-md-4 flex-horizontal-center list-group-item text-lh-sm mb-2">
                        <i class="flaticon-alarm text-primary font-size-22 mr-2 d-block"></i>
                        @if(app()->getLocale() == 'ur')
                            <div class="ml-1 text-gray-1">@lang('content.category'): {{ $product->categories->name_urdu }}</div>
                        @elseif(app()->getLocale() == 'ar')
                            <div class="ml-1 text-gray-1">@lang('content.category'): {{ $product->categories->name_arabic }}</div>
                        @else
                        <div class="ml-1 text-gray-1">@lang('content.category'): {{ $product->categories->name }}</div>

                        @endif
                    </li>
                    <li class="col-md-4 flex-horizontal-center list-group-item text-lh-sm mb-2">
                        {{-- <i class="flaticon-social text-primary font-size-22 mr-2 d-block"></i>
                        <div class="ml-1 text-gray-1">Max People : </div> --}}
                    </li>
                    
                    <li class="col-md-4 flex-horizontal-center list-group-item text-lh-sm mb-2">
                        <i class="flaticon-pin text-primary font-size-22 mr-2 d-block"></i>
                        <div class="ml-1 text-gray-1">@lang('content.stock'): {{ ($product->status == 1) ? 'Available': 'Unavailable' }}</div>
                    </li>
                </ul>
            </div>
            <div class="border-bottom position-relative">
                <h5 class="font-size-21 font-weight-bold text-dark mb-3">
                    @lang('content.description')
                </h5>
                @if(app()->getLocale() == 'ur')
                    <p class="mb-4">{{ $product->description_urdu }}</p>
                @elseif(app()->getLocale() == 'ar')
                    <p class="mb-4">{{ $product->description_arabic }}</p>
                @else
                    <p class="mb-4">{{ $product->description }}</p>
                @endif
            </div>

        </div>
        <div class="col-lg-3 col-xl-3">
            <div class="mb-4">
                <div class="border border-color-7 rounded mb-5">
                    <div class="border-bottom">
                        <div class="p-4">
                            <span class="font-size-14">@lang('content.price')</span>
                            <span class="font-size-24 text-gray-6 font-weight-bold ml-1">${{ $product->price }}.00</span>
                        </div>
                    </div>
                    <div class="p-4">

                        <!-- Input -->
                       {{--  <span class="d-block text-gray-1 font-weight-normal mb-2 text-left">Number Of Person</span>
                        <div class="mb-4">
                            <div class="border-bottom border-width-2 border-color-1 pb-1">
                                <div class="js-quantity flex-center-between mb-1 text-dark font-weight-bold">
                                    
                                    <div class="flex-horizontal-center">
                                        <a class="js-minus font-size-10 text-dark" href="javascript:;">
                                            <i class="fas fa-chevron-up"></i>
                                        </a>
                                        <input class="js-result form-control h-auto width-30 font-weight-bold font-size-16 shadow-none bg-tranparent border-0 rounded p-0 mx-1 text-center" type="text" value="1" min="01" max="{{ $trip->available_of_person }}">
                                        <a class="js-plus font-size-10 text-dark" href="javascript:;">
                                            <i class="fas fa-chevron-down"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        <!-- End Input -->

                        <div class="text-center">
                            <a href="{{ url('add-cart/'.$product->id) }}" class="btn btn-primary d-flex align-items-center justify-content-center  height-60 w-100 mb-xl-0 mb-lg-1 transition-3d-hover font-weight-bold">@lang('content.add_cart')</a>
                        </div>
                    </div>
                </div>
                <div class="border border-color-7 rounded p-4 mb-5">
                    <h6 class="font-size-17 font-weight-bold text-gray-3 mx-1 mb-3 pb-1">@lang('content.why_book')?</h6>
                    <div class="d-flex align-items-center mb-3">
                        <i class="flaticon-star font-size-25 text-primary mr-3 pr-1"></i>
                        <h6 class="mb-0 font-size-14 text-gray-1">
                            <a href="#">@lang('content.no_hassle')</a>
                        </h6>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <i class="flaticon-support font-size-25 text-primary mr-3 pr-1"></i>
                        <h6 class="mb-0 font-size-14 text-gray-1">
                            <a href="#">@lang('content.customer_care')</a>
                        </h6>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <i class="flaticon-favorites-button font-size-25 text-primary mr-3 pr-1"></i>
                        <h6 class="mb-0 font-size-14 text-gray-1">
                            <a href="#">@lang('content.hand_picked') &amp; @lang('content.activities')</a>
                        </h6>
                    </div>
                    <!-- <div class="d-flex align-items-center mb-0">
                        <i class="flaticon-airplane font-size-25 text-primary mr-3 pr-1"></i>
                        <h6 class="mb-0 font-size-14 text-gray-1">
                            <a href="#">@lang('content.travel_insurance')</a>
                        </h6>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
   
</div>
</main>
@endsection
@section('front-additional-js')
@endsection