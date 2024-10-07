@extends('layouts.front.master')
@section('title')
Home
@endsection
@section('front-additional-css')

<style>
    .selectbox>.bootstrap-select {
        width: 100% !important;
    }

    .search-btn>button {
        width: 100%
    }

    @media (min-width: 991px) and (max-width: 1196px) {
        .search-btn>button {
            width: 22% !important;
            margin-top: 2rem
        }

        .search-btn {
            /* width: 22%!important; */
            margin-top: 1rem
        }
    }

    .text-start {
        text-align: start !important
    }

    .bootstrap-select .filter-option {
        text-align: start !important
    }

    .flatpickr-calendar {
        border-radius: 0px !important;
    }

    .datepicker {
        width: 100% !important;
        outline: none !important;
        border: none;
    }

    .flatpickr-months {
        padding: 2rem 0rem;
        background-color: #018578;
    }

    .flatpickr-months .flatpickr-prev-month,
    .flatpickr-months .flatpickr-next-month {
        padding: 2rem 1rem;
    }

    .flatpickr-months .flatpickr-prev-month svg path,
    .flatpickr-months .flatpickr-next-month svg path {
        fill: #fff !important;
    }

    .flatpickr-months .flatpickr-current-month {
        padding: 0px !important;
        color: #fff;
    }

    .flatpickr-days .dayContainer .today {
        color: #000;
        background-color: transparent;
        border-color: #018578;
        transition: all 0.5s cubic-bezier(0.215, 0.610, 0.355, 1);
    }

    .flatpickr-days .dayContainer .today:hover {
        background-color: #018578;
        color: #fff;
        border-color: unset;
    }

    .flatpickr-current-month .numInputWrapper {
        padding: 0px 5px;
    }

    .dayContainer .selected {
        background-color: #018578c2;
        transition: all 0.5s cubic-bezier(0.215, 0.610, 0.355, 1);
        border-color: unset;
    }

    .dayContainer .selected:hover {
        background-color: #018578;
        border-color: unset;
    }

    /* ddddd */

    .news-container {
        /* position: fixed; */
        top: 0;
        left: 0;
        right: 0;
        font-family: "Roboto", sans-serif;
        box-shadow: 0 4px 8px -4px rgba(0, 0, 0, 0.3);
    }
    .top-header{
        padding-left:60px;
    }

    .top-header .news-container .title {
        position: absolute;
        background: #833AB4;
        /* height: 100%; */
        top:0;
        left:53px;
        display: flex;
        align-items: center;
        padding: 12px 24px;
        color: white;
        font-weight: bold;
        z-index: 200;
    }

    .news-container .title {
        position: absolute;
        background: #df2020;
        /* height: 100%; */
        display: flex;
        align-items: center;
        padding: 10px 24px;
        color: white;
        font-weight: bold;
        z-index: 200;
    }

    @keyframes scroll {
        from {
            transform: translateX(100%);
        }

        to {
            transform: translateX(-500px);

        }
    }
    marquee{
        color:white;
        padding-top:5px;
    }
    
    .bigger-pipe {
        font-size: 1.5em;
    }

    /* ddddd */
</style>
@endsection
@section('content')
@include('layouts.front.include.header')
@if(session('payment_failed'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Payment has been failed. Please try again.',
        });
        @php
            session()->forget('payment_failed');
        @endphp
    </script>
@endif


<main id="content">
    
    <!-- ========== HERO ========== -->
    @if(count($sliders) > 0)
        <div class="hero-block hero-v1 bg-img-hero-bottom gradient-overlay-half-black-gradient text-center z-index-2 jarallax backgrounds" data-jarallax='{"speed": 0.3}'>
    @else
        <div class="hero-block hero-v1 bg-img-hero-bottom gradient-overlay-half-black-gradient text-center z-index-2" style="background-image: url({{ asset('front/assets/img/1920x800/ori-img1.jpg') }});">
    @endif

        <div class="container space-2 space-top-xl-9">
            <div class="row justify-content-md-center pb-xl-8">
                <!-- Info -->
                <div class="py-8 py-xl-10 pb-5">
                    @if(count($sliders) > 0)
                        @foreach($sliders as $slider)
                            @if(app()->getLocale() == 'ur')
                                <h1 class="font-size-60 font-size-xs-30 text-white font-weight-bold">{{ $slider->title_urdu }}!</h1>
                                <p class="font-size-20 font-weight-normal text-white">{{ $slider->description_urdu }}</p>
                            @elseif(app()->getLocale() == 'ar')
                                <h1 class="font-size-60 font-size-xs-30 text-white font-weight-bold">{{ $slider->title_arabic }}!</h1>
                                <p class="font-size-20 font-weight-normal text-white">{{ $slider->description_arabic }}</p>
                            @else
                                <h1 class="font-size-60 font-size-xs-30 text-white font-weight-bold">{{ $slider->title }}!</h1>
                                <p class="font-size-20 font-weight-normal text-white">{{ $slider->description }}</p>
                            @endif
                        @endforeach
                    @else
                        <h1 class="font-size-60 font-size-xs-30 text-white font-weight-bold">@lang('home.lets_the_world')!</h1>
                        <p class="font-size-20 font-weight-normal text-white">@lang('home.find_hotel_etc')</p>
                    @endif
                    <!--<a href="#" class="btn btn-sm btn-primary text-center text-white">App Link</a>-->
                    <a target="_blank" href="https://play.google.com/store/apps/details?id=com.tamoheen"> <img height="50px" src="{{ asset('storage/assets/playstore.png') }}" alt=""> </a>
                    <a target="_blank" href="https://apps.apple.com/us/app/tamoheen/id1636544470">  <img height="50px" src="{{ asset('storage/assets/appstore.png') }}" alt=""> </a>
                </div>
                <!-- End Info -->
            </div>
            <div class="mb-lg-n16">
                <!-- Nav Classic -->
                <ul class="nav tab-nav-rounded flex-nowrap pb-2 pb-md-4 tab-nav" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link font-weight-medium active pl-md-5 pl-3" id="pills-five-example2-tab" data-toggle="pill" href="#pills-five-example2" role="tab" aria-controls="pills-five-example2" aria-selected="true">
                            <div class="d-flex flex-column flex-md-row  position-relative text-white align-items-center">
                                <figure class="ie-height-40 d-md-block mr-md-3">
                                    <i class="icon flaticon-sedan font-size-3"></i>
                                </figure>
                                <span class="tabtext mt-2 mt-md-0 font-weight-semi-bold">@lang('home.rideShare')</span>
                            </div>
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link font-weight-medium pl-md-5 pl-3" id="pills-five-example3-tab" data-toggle="pill" href="#pills-five-example3" role="tab" aria-controls="pills-five-example2" aria-selected="true">
                            <div class="d-flex flex-column flex-md-row  position-relative text-white align-items-center">
                                <figure class="ie-height-40 d-md-block mr-md-3">
                                    <i class="icon flaticon-sedan font-size-3"></i>
                                </figure>
                                <span class="tabtext mt-2 mt-md-0 font-weight-semi-bold">Shipment</span>
                            </div>
                        </a>
                    </li> --}}

                </ul>
                <!-- End Nav Classic -->
                <div class="tab-content hero-tab-pane">
                    <div class="tab-pane fade active show" id="pills-five-example2" role="tabpanel" aria-labelledby="pills-five-example2-tab">
                        <!-- Search Jobs Form -->
                        <div class="card border-0 tab-shadow">
                            <div class="card-body">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <form class="js-validate" action="{{ url('trip-list') }}" method="GET">
                                    @csrf
                                  <div class="row d-block nav-select d-lg-flex mb-lg-3 px-2 px-lg-3 align-items-end">
                                    <div class="col-12 col-md-12 col-lg-6  col-xl-3 mb-3 mb-lg-0">
                                        <span class="d-block text-gray-1 font-weight-normal text-start mb-0">@lang('home.what_state_from')</span>
                                        <!-- Select -->
                                        <select class="js-select selectpicker dropdown-select tab-dropdown col-12 pl-0 flaticon-pin-1 d-flex align-items-center text-primary font-weight-semi-bold" title="@lang('home.what_state_from')"
                                            data-style=""
                                            data-live-search="true"
                                            data-searchbox-classes="input-group-sm" name="city_from" required>
                                            @if(app()->getLocale() == 'ur')
                                                @foreach($cities as $city)
                                                <option class="border-bottom border-color-1 text-start" value="{{ $city->id }}" data-content='
                                                    <span class="d-flex align-items-center">
                                                        <span class="font-size-16">{{ $city->name_urdu }}</span>
                                                    </span>'>
                                                    {{ $city->name }}
                                                </option>
                                                @endforeach
                                            @elseif(app()->getLocale() == 'ar')
                                                @foreach($cities as $city)
                                                <option class="border-bottom border-color-1 text-start" value="{{ $city->id }}" data-content='
                                                    <span class="d-flex align-items-center">
                                                        <span class="font-size-16">{{ $city->name_arabic }}</span>
                                                    </span>'>
                                                    {{ $city->name }}
                                                </option>
                                                @endforeach
                                            @else
                                                @foreach($cities as $city)
                                                <option class="border-bottom border-color-1 text-start" value="{{ $city->id }}" data-content='
                                                    <span class="d-flex align-items-center">
                                                        <span class="font-size-16">{{ $city->name }}</span>
                                                    </span>'>
                                                    {{ $city->name }}
                                                </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <!-- End Select -->
                                    </div>

                                    <div class="col-12 col-md-12 col-lg-6  col-xl-3  mb-3 mb-lg-0">
                                        <span class="d-block text-gray-1 font-weight-normal text-start mb-0">@lang('home.destination')</span>
                                        <!-- Select -->
                                        <select class="js-select selectpicker dropdown-select tab-dropdown col-12 pl-0 flaticon-pin-1 d-flex align-items-center text-primary font-weight-semi-bold" title="@lang('home.destination')"
                                            data-style=""
                                            data-live-search="true"
                                            data-searchbox-classes="input-group-sm" name="city_to" required>
                                            @if(app()->getLocale() == 'ur')
                                                @foreach($cities as $city)
                                                <option class="border-bottom border-color-1 text-start" value="{{ $city->id }}" data-content='
                                                    <span class="d-flex align-items-center">
                                                        <span class="font-size-16">{{ $city->name_urdu }}</span>
                                                    </span>'>
                                                    {{ $city->name }}
                                                </option>
                                                @endforeach
                                            @elseif(app()->getLocale() == 'ar')
                                                @foreach($cities as $city)
                                                <option class="border-bottom border-color-1 text-start" value="{{ $city->id }}" data-content='
                                                    <span class="d-flex align-items-center">
                                                        <span class="font-size-16">{{ $city->name_arabic }}</span>
                                                    </span>'>
                                                    {{ $city->name }}
                                                </option>
                                                @endforeach
                                            @else
                                                @foreach($cities as $city)
                                                <option class="border-bottom border-color-1 text-start" value="{{ $city->id }}" data-content='
                                                    <span class="d-flex align-items-center">
                                                        <span class="font-size-16">{{ $city->name }}</span>
                                                    </span>'>
                                                    {{ $city->name }}
                                                </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <!-- End Select -->
                                    </div>

                                    <div class="col-12 col-md-12 col-lg-6  col-xl-3  mb-3 mb-lg-0 ">
                                        <!-- Input -->
                                        <span class="d-block text-gray-1 text-start font-weight-normal mb-0">@lang('home.trip_date')</span>
                                        <div class="border-bottom border-width-2 border-color-1">
                                            <div id="datepickerWrapperFromOne" class="u-datepicker input-group">
                                                <div class="input-group-prepend">
                                                    <span class="d-flex align-items-center mr-2">
                                                      <i class="flaticon-calendar text-primary font-weight-semi-bold"></i>
                                                      <input type="text" name="date" class="js-range-datepicker datepicker form-control hero-form bg-transparent  border-0 font-size-16 shadow-none">
                                                    </span>
                                                </div>
                                                
                                            </div>
                                           
                                        </div>
                                      
                                    </div>

                                    <input type="hidden" name="type" value="1">


                                    <div class="col-12 col-md-12 col-lg-6  col-xl-3  mb-3 mb-lg-0" id="number_of_person">
                                    <div   class="d-flex">
                                       <div  class="mr-2 selectbox" style="flex: 1">

                                           <span class="d-block text-gray-1 font-weight-normal text-start mb-0">@lang('home.number_of_person')</span>
                                         
                                           <select  class="js-select selectpicker dropdown-select tab-dropdown   pl-0 flaticon-pin-1 d-flex align-items-center text-primary font-weight-semi-bold" title="@lang('home.number_of_person')"
                                               data-style=""
                                               data-live-search="true"
                                               data-searchbox-classes="input-group-sm" name="number_of_person" required>
                                               <option class="border-bottom border-color-1" value="1" data-content='
                                                   <span class="d-flex align-items-center">
                                                       <span class="font-size-16">1</span>
                                                   </span>'>
                                                   1
                                               </option>
                                               <option class="border-bottom border-color-1" value="2" data-content='
                                                   <span class="d-flex align-items-center">
                                                       <span class="font-size-16">2</span>
                                                   </span>'>
                                                   2
                                               </option>
                                               <option class="border-bottom border-color-1" value="3" data-content='
                                                   <span class="d-flex align-items-center">
                                                       <span class="font-size-16">3</span>
                                                   </span>'>
                                                   3
                                               </option>
                                               <option class="border-bottom border-color-1" value="4" data-content='
                                                   <span class="d-flex align-items-center">
                                                       <span class="font-size-16">4</span>
                                                   </span>'>
                                                   4
                                               </option>
                                               <option class="border-bottom border-color-1" value="5" data-content='
                                                   <span class="d-flex align-items-center">
                                                       <span class="font-size-16">5</span>
                                                   </span>'>
                                                   5
                                               </option>
                                               <option class="border-bottom border-color-1" value="6" data-content='
                                                   <span class="d-flex align-items-center">
                                                       <span class="font-size-16">6</span>
                                                   </span>'>
                                                   6
                                               </option>
                                               <option class="border-bottom border-color-1" value="7" data-content='
                                                   <span class="d-flex align-items-center">
                                                       <span class="font-size-16">7</span>
                                                   </span>'>
                                                   7
                                               </option>
                                               <option class="border-bottom border-color-1" value="8" data-content='
                                                   <span class="d-flex align-items-center">
                                                       <span class="font-size-16">8</span>
                                                   </span>'>
                                                   8
                                               </option>
                                               <option class="border-bottom border-color-1" value="9" data-content='
                                                   <span class="d-flex align-items-center">
                                                       <span class="font-size-16">9</span>
                                                   </span>'>
                                                   9
                                               </option>
                                               <option class="border-bottom border-color-1" value="10" data-content='
                                                   <span class="d-flex align-items-center">
                                                       <span class="font-size-16">10</span>
                                                   </span>'>
                                                   10
                                               </option>
                                           </select>
                                       </div>
                                       <div class="d-none d-xl-block">

                                           <button type="submit" class="btn btn-primary btn-sm border-radius-3 ml-auto mt-5  transition-3d-hover"><i class="flaticon-magnifying-glass font-size-16 "></i></button>
                                       </div>
                                    </div>
                                        <!-- End Select -->
                                    </div>
                                    <div class="w-100 d-xl-none search-btn">
                                        <button  type="submit" class="btn btn-primary border-radius-3 mt-2 transition-3d-hover   "><i class="flaticon-magnifying-glass font-size-16 mr-2"></i>@lang('home.search')</button>
                                    </div>



                                    {{-- <div class="col-sm-12 col-lg-2 col-xl-3gdot5 mb-4 mb-lg-0" id="product_type">
                                        <span class="d-block text-gray-1 font-weight-normal text-start mb-0">Trip Type</span>
                                        <!-- Select -->
                                        <select class="js-select selectpicker dropdown-select tab-dropdown col-12 pl-0 flaticon-pin-1 d-flex align-items-center text-primary font-weight-semi-bold features" title="Trip Type"
                                            data-style=""
                                            data-live-search="true"
                                            data-searchbox-classes="input-group-sm" name="main_feature_id">

                                            @foreach($features as $key => $feature)
                                            <option class="border-bottom border-color-1" value="{{ $key }}" data-content='
                                                <span class="d-flex align-items-center">
                                                    <span class="font-size-16">{{ $feature }}</span>
                                                </span>'>
                                                {{ $feature }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <!-- End Select -->
                                    </div> --}}
                                    {{-- <div class="col-sm-12 col-lg-2 col-xl-3gdot5 mb-4 mb-lg-0" id="product_type">
                                        <span class="d-block text-gray-1 font-weight-normal text-start mb-0">Feature</span>
                                        <!-- Select -->
                                        <select class="js-select selectpicker dropdown-select tab-dropdown col-12 pl-0 flaticon-pin-1 d-flex align-items-center text-primary font-weight-semi-bold features" title="Trip Type"
                                            data-style=""
                                            data-live-search="true"
                                            data-searchbox-classes="input-group-sm" name="feature_id[]" multiple>

                                            @foreach($other_features as $key => $feature)
                                            <option class="border-bottom border-color-1" value="{{ $key }}" data-content='
                                                    <span class="font-size-16">{{ $feature }}</span>'>
                                                {{ $feature }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <!-- End Select -->
                                    </div> --}}
                                  </div>
                                  {{-- <div class="row">
                                        <div class="col-sm-12 col-lg-2 align-self-lg-end text-md-right mx-auto  ">
                                            <button type="submit" class="btn btn-primary btn-sm border-radius-3  transition-3d-hover"><i class="flaticon-magnifying-glass font-size-16 "></i></button>
                                        </div>
                                  </div> --}}

                                  <!-- End Checkbox -->
                                </form>
                            </div>
                        </div>
                        <!-- End Search Jobs Form -->
                    </div>
                    {{-- <div class="tab-pane fade" id="pills-five-example3" role="tabpanel" aria-labelledby="pills-five-example3-tab">
                        <!-- Search Jobs Form -->
                        <div class="card border-0 tab-shadow">
                            <div class="card-body">
                                <form class="js-validate" action="{{ url('ship-list') }}" method="GET">
                                    @csrf
                                  <div class="row d-block nav-select d-lg-flex mb-lg-3 px-2 px-lg-3 align-items-end">
                                    <div class="col-sm-12 col-lg-3dot6 col-xl-3gdot5 mb-4 mb-lg-0">
                                        <span class="d-block text-gray-1 font-weight-normal text-start mb-0">@lang('home.what_state_from')?</span>
                                        <!-- Select -->
                                        <select class="js-select selectpicker dropdown-select tab-dropdown col-12 pl-0 flaticon-pin-1 d-flex align-items-center text-primary font-weight-semi-bold" title="@lang('home.what_state_from')?"
                                            data-style=""
                                            data-live-search="true"
                                            data-searchbox-classes="input-group-sm" name="city_from">
                                            @if(app()->getLocale() == 'ur')
                                                @foreach($cities as $city)
                                                <option class="border-bottom border-color-1" value="{{ $city->id }}" data-content='
                                                    <span class="d-flex align-items-center">
                                                        <span class="font-size-16">{{ $city->name_urdu }}</span>
                                                    </span>'>
                                                    {{ $city->name }}
                                                </option>
                                                @endforeach
                                            @elseif(app()->getLocale() == 'ar')
                                                @foreach($cities as $city)
                                                <option class="border-bottom border-color-1" value="{{ $city->id }}" data-content='
                                                    <span class="d-flex align-items-center">
                                                        <span class="font-size-16">{{ $city->name_arabic }}</span>
                                                    </span>'>
                                                    {{ $city->name }}
                                                </option>
                                                @endforeach
                                            @else
                                                @foreach($cities as $city)
                                                <option class="border-bottom border-color-1" value="{{ $city->id }}" data-content='
                                                    <span class="d-flex align-items-center">
                                                        <span class="font-size-16">{{ $city->name }}</span>
                                                    </span>'>
                                                    {{ $city->name }}
                                                </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <!-- End Select -->
                                    </div>

                                    <div class="col-sm-12 col-lg-3dot6 col-xl-3gdot5 mb-4 mb-lg-0">
                                        <span class="d-block text-gray-1 font-weight-normal text-start mb-0">@lang('home.destination')</span>
                                        <!-- Select -->
                                        <select class="js-select selectpicker dropdown-select tab-dropdown col-12 pl-0 flaticon-pin-1 d-flex align-items-center text-primary font-weight-semi-bold" title="@lang('home.destination')"
                                            data-style=""
                                            data-live-search="true"
                                            data-searchbox-classes="input-group-sm" name="city_to">
                                            @if(app()->getLocale() == 'ur')
                                                @foreach($cities as $city)
                                                <option class="border-bottom border-color-1" value="{{ $city->id }}" data-content='
                                                    <span class="d-flex align-items-center">
                                                        <span class="font-size-16">{{ $city->name_urdu }}</span>
                                                    </span>'>
                                                    {{ $city->name }}
                                                </option>
                                                @endforeach
                                            @elseif(app()->getLocale() == 'ar')
                                                @foreach($cities as $city)
                                                <option class="border-bottom border-color-1" value="{{ $city->id }}" data-content='
                                                    <span class="d-flex align-items-center">
                                                        <span class="font-size-16">{{ $city->name_arabic }}</span>
                                                    </span>'>
                                                    {{ $city->name }}
                                                </option>
                                                @endforeach
                                            @else
                                                @foreach($cities as $city)
                                                <option class="border-bottom border-color-1" value="{{ $city->id }}" data-content='
                                                    <span class="d-flex align-items-center">
                                                        <span class="font-size-16">{{ $city->name }}</span>
                                                    </span>'>
                                                    {{ $city->name }}
                                                </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <!-- End Select -->
                                    </div>

                                    <div class="col-sm-12 col-lg-3dot7 col-xl-3gdot5 mb-4 mb-lg-0 ">
                                        <!-- Input -->
                                        <span class="d-block text-gray-1 text-start font-weight-normal mb-0">@lang('home.trip_date')</span>
                                        <div class="border-bottom border-width-2 border-color-1">
                                            <div id="datepickerWrapperFromTwo" class="u-datepicker input-group">
                                                <div class="input-group-prepend">
                                                    <span class="d-flex align-items-center mr-2">
                                                      <i class="flaticon-calendar text-primary font-weight-semi-bold"></i>
                                                    </span>
                                                </div>
                                                 <input name="date" class="js-range-datepicker font-size-16 shadow-none font-weight-medium form-control hero-form bg-transparent  border-0" type="date"
                                                     data-rp-wrapper="#datepickerWrapperFromTwo"
                                                     data-rp-type="single"
                                                     data-rp-date-format="M d Y">
                                            </div>
                                             <!-- End Datepicker -->
                                        </div>
                                        <!-- End Input -->
                                    </div>

                                    <div class="col-sm-12 col-lg-3dot6 col-xl-3gdot5 mb-4 mb-lg-0">
                                        <span class="d-block text-gray-1 font-weight-normal text-start mb-0">Product Type</span>
                                        <!-- Select -->
                                        <select class="js-select selectpicker dropdown-select tab-dropdown col-12 pl-0 flaticon-pin-1 d-flex align-items-center text-primary font-weight-semi-bold" title="Product Type"
                                            data-style=""
                                            data-live-search="true"
                                            data-searchbox-classes="input-group-sm" name="product_type_id">
                                            @if(app()->getLocale() == 'ur')
                                                @foreach($product_types as $type)
                                                <option class="border-bottom border-color-1" value="{{ $type->id }}" data-content='
                                                    <span class="d-flex align-items-center">
                                                        <span class="font-size-16">{{ $type->name_urdu }}</span>
                                                    </span>'>
                                                    {{ $type->name_urdu }}
                                                </option>
                                                @endforeach
                                            @elseif(app()->getLocale() == 'ar')
                                                @foreach($product_types as $type)
                                                <option class="border-bottom border-color-1" value="{{ $type->id }}" data-content='
                                                    <span class="d-flex align-items-center">
                                                        <span class="font-size-16">{{ $type->name_arabic }}</span>
                                                    </span>'>
                                                    {{ $type->name_arabic }}
                                                </option>
                                                @endforeach
                                            @else
                                                @foreach($product_types as $type)
                                                <option class="border-bottom border-color-1" value="{{ $type->id }}" data-content='
                                                    <span class="d-flex align-items-center">
                                                        <span class="font-size-16">{{ $type->name }}</span>
                                                    </span>'>
                                                    {{ $type->name }}
                                                </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <!-- End Select -->
                                    </div>

                                    <input type="hidden" name="type" value="2">

                                    <div class="col-sm-12 col-lg-2 col-xl-3gdot5 mb-4 mb-lg-0" id="number_of_bag">
                                        <span class="d-block text-gray-1 font-weight-normal text-start mb-0">Number Of Bag</span>
                                        <!-- Select -->
                                        <select class="js-select selectpicker dropdown-select tab-dropdown col-12 pl-0 flaticon-pin-1 d-flex align-items-center text-primary font-weight-semi-bold" title="Number Of Bag"
                                            data-style=""
                                            data-live-search="true"
                                            data-searchbox-classes="input-group-sm" name="number_of_bag">
                                            <option class="border-bottom border-color-1" value="1" data-content='
                                                <span class="d-flex align-items-center">
                                                    <span class="font-size-16">1</span>
                                                </span>'>
                                                1
                                            </option>
                                            <option class="border-bottom border-color-1" value="2" data-content='
                                                <span class="d-flex align-items-center">
                                                    <span class="font-size-16">2</span>
                                                </span>'>
                                                2
                                            </option>
                                            <option class="border-bottom border-color-1" value="3" data-content='
                                                <span class="d-flex align-items-center">
                                                    <span class="font-size-16">3</span>
                                                </span>'>
                                                3
                                            </option>
                                            <option class="border-bottom border-color-1" value="4" data-content='
                                                <span class="d-flex align-items-center">
                                                    <span class="font-size-16">4</span>
                                                </span>'>
                                                4
                                            </option>
                                            <option class="border-bottom border-color-1" value="5" data-content='
                                                <span class="d-flex align-items-center">
                                                    <span class="font-size-16">5</span>
                                                </span>'>
                                                5
                                            </option>
                                        </select>
                                        <!-- End Select -->
                                    </div>
                                  	</div>
                                  	<div class="row">
                                        <div class="col-sm-12 col-lg-2 align-self-lg-end text-md-right mx-auto d-block">
                                            <button type="submit" class="btn btn-primary w-100 border-radius-3 mb-xl-0 mb-lg-1 transition-3d-hover btn-block"><i class="flaticon-magnifying-glass font-size-20 mr-2"></i>@lang('home.search')</button>
                                        </div>
                                  	</div>

                                  <!-- End Checkbox -->
                                </form>
                            </div>
                        </div>
                        <!-- End Search Jobs Form -->
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
    <!-- ========== END HERO ========== -->

    <!-- Destinantion v1 -->
    <div class="destinantion-block destinantion-v1 border-bottom border-color-8">
        <div class="container space-bottom-1 space-top-lg-3">
            <div class="w-md-80 w-lg-50 text-center mx-md-auto mb-5 mt-4">
                <h2 class="section-title text-black font-size-30 font-weight-bold mb-0">@lang('home.top_destination')</h2>
            </div>
            <div class="row mb-1">
                <!-- Card Block -->
                @foreach($top_cities as $city)
                <div class="col-md-4 mb-3 mb-md-4">
                    <a href="{{ url('city/'.$city->id) }}">
                        @if(isset($city->images) && count($city->images) > 0)
                            <div class="min-height-350 bg-img-hero rounded-border p-5 gradient-overlay-half-bg-gradient transition-3d-hover shadow-hover-2 border-0 dropdown" style="background-image: url({{ $city->images[0]->url }});">
                        @else
                            <div class="min-height-350 bg-img-hero rounded-border p-5 gradient-overlay-half-bg-gradient transition-3d-hover shadow-hover-2 border-0 dropdown" style="background-color: green;">
                        @endif
                            <div class="w-100 d-flex justify-content-between mb-2">
                                <div class="position-relative">
                                    <span class="destination text-white font-weight-bold font-size-21 pb-3 mb-3 text-lh-1 d-block">
                                        @if(app()->getLocale() == 'ar')
                                            {{ $city->name_arabic }}
                                        @else
                                            {{ $city->name }}
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
                <!-- End Card Block -->

                {{-- <!-- Card Block -->
                <div class="col-md-6 mb-3 mb-md-4">
                        <div class="min-height-350 bg-img-hero rounded-border p-5 gradient-overlay-half-bg-gradient transition-3d-hover shadow-hover-2 border-0 dropdown" style="background-image: url(front/assets/images/jeddah.jpg);">
                            <header class="w-100 d-flex justify-content-between mb-2">
                                <div class="position-relative">
                                    <a href="{{ url('/jeddah') }}" class="destination text-white font-weight-bold font-size-21 pb-3 mb-3 text-lh-1 d-block">@lang('home.jeddah')</a>


                                </div>
                            </header>
                        </div>
                </div>
                <!-- End Card Block --> --}}

                {{-- <!-- Card Block -->
                <div class="col-md-6 col-xl-3 mb-3 mb-md-4">
                    <div class="min-height-350 gradient-overlay-half-bg-gradient rounded-border p-5 bg-img-hero transition-3d-hover shadow-hover-2 border-0 dropdown" style="background-image: url(front/assets/images/makkah.jpg);">
                        <header class="w-100 d-flex justify-content-between mb-2">
                            <div class="position-relative">
                                <a href="{{ url('/makkah') }}" class="destination text-white font-weight-bold font-size-21 pb-3 mb-3 text-lh-1 d-block">@lang('home.makkah')</a>


                            </div>
                        </header>
                    </div>
                </div>
                <!-- End Card Block -->

                <!-- Card Block -->
                <div class="col-md-6 col-xl-3 mb-3 mb-md-4">
                    <div class="min-height-350 gradient-overlay-half-bg-gradient rounded-border p-5 bg-img-hero transition-3d-hover shadow-hover-2 border-0 dropdown" style="background-image: url(front/assets/images/medina.jpg);">
                        <header class="w-100 d-flex justify-content-between mb-2">
                            <div class="position-relative">
                                <a href="{{ url('/medina') }}" class="destination text-white font-weight-bold font-size-21 pb-3 mb-3 text-lh-1 d-block">@lang('home.medina')</a>


                            </div>
                        </header>
                    </div>
                </div>
                <!-- End Card Block -->

                <!-- Card Block -->
                <div class="col-md-6 col-xl-3 mb-3 mb-md-4">
                    <div class="min-height-350 gradient-overlay-half-bg-gradient rounded-border p-5 bg-img-hero transition-3d-hover shadow-hover-2 border-0 dropdown" style="background-image: url(front/assets/images/dammam.jpg);">
                        <header class="w-100 d-flex justify-content-between mb-2">
                            <div class="position-relative">
                                <a href="{{ url('/dammam') }}" class="destination text-white font-weight-bold font-size-21 pb-3 mb-3 text-lh-1 d-block">@lang('home.dammam')</a>

                            </div>
                        </header>
                    </div>
                </div>
                <!-- End Card Block -->

                <!-- Card Block -->
                <div class="col-md-6 col-xl-3 mb-3 mb-md-4">
                    <div class="min-height-350 gradient-overlay-half-bg-gradient rounded-border p-5 bg-img-hero transition-3d-hover shadow-hover-2 border-0 dropdown" style="background-image: url(front/assets/images/tabuk.jpg);">
                        <header class="w-100 d-flex justify-content-between mb-2">
                            <div class="position-relative">
                                <a href="{{ url('/tabuk') }}" class="destination text-white font-weight-bold font-size-21 pb-3 mb-3 text-lh-1 d-block">@lang('home.tabuk')</a>


                            </div>
                        </header>
                    </div>
                </div> --}}
                <!-- End Card Block -->
            </div>
        </div>
    </div>
    <!-- End Destinantion v1 -->

    <!-- Tabs v1 -->
    {{-- <div class="tabs-block tab-v1">
        <div class="container space-1">
            <div class="w-md-80 w-lg-50 text-center mx-md-auto my-3">
                <h2 class="section-title text-black font-size-30 font-weight-bold mb-0">@lang('home.shop')</h2>
            </div>
            <!-- Nav Classic -->
            <ul class="nav tab-nav-pill flex-nowrap pb-4 pb-lg-5 tab-nav justify-content-lg-center" role="tablist">
                @if(app()->getLocale() == 'ur')
                	@foreach($categories as $value)
                    <li class="nav-item">
                        <a class="nav-link font-weight-medium {{ ($loop->iteration == 1) ? 'active' : '' }}"  id="pills-one-example-t100-tab" data-toggle="tab" onclick="openTab({{ $value->id }})" role="tab" >
                            <div class="d-flex flex-column flex-md-row  position-relative text-dark align-items-center">
                                <span class="tabtext font-weight-semi-bold">{{  $value->name_urdu }}</span>
                            </div>
                        </a>
                    </li>
                    @endforeach
                @elseif(app()->getLocale() == 'ar')
                    @foreach($categories as $value)
                    <li class="nav-item">
                        <a class="nav-link font-weight-medium {{ ($loop->iteration == 1) ? 'active' : '' }}"  id="pills-one-example-t100-tab" data-toggle="tab" onclick="openTab({{ $value->id }})" role="tab" >
                            <div class="d-flex flex-column flex-md-row  position-relative text-dark align-items-center">
                                <span class="tabtext font-weight-semi-bold">{{  $value->name_arabic }}</span>
                            </div>
                        </a>
                    </li>
                    @endforeach
                @else
                    @foreach($categories as $value)
                    <li class="nav-item">
                        <a class="nav-link font-weight-medium {{ ($loop->iteration == 1) ? 'active' : '' }}"  id="pills-one-example-t100-tab" data-toggle="tab" onclick="openTab({{ $value->id }})" role="tab" >
                            <div class="d-flex flex-column flex-md-row  position-relative text-dark align-items-center">
                                <span class="tabtext font-weight-semi-bold">{{  $value->name }}</span>
                            </div>
                        </a>
                    </li>
                    @endforeach
                @endif
            </ul>
            <!-- End Nav Classic -->
            <div class="tab-content">
            	@foreach($categories as $value1)
                <div class="tab-pane product-section fade show {{ ($loop->iteration == 1) ? 'active' : '' }}"  id="tab{{ $value1->id }}" role="tabpanel" aria-labelledby="pills-one-example-t100-tab">
                    <div class="row">
                        @if(app()->getLocale() == 'ur')
                    	@foreach($products as $item)
                    	@if($value1->id == $item->category_id)
                        	<div class="col-md-6 col-lg-4 col-xl-3 mb-3 mb-md-4 pb-1">
                            <div class="card mb-1 transition-3d-hover shadow-hover-2 tab-card h-100">
                                <div class="position-relative mb-2">
                                    <a href="{{ url('single-product/'.$item->id) }}" class="d-block gradient-overlay-half-bg-gradient-v5">
                                        <img class="card-img-top" src="{{ $item->image->url) }}" alt="img">
                                    </a>
                                    <div class="position-absolute top-0 right-0 pt-5 pr-3">
                                      <button type="button" class="btn btn-sm btn-icon text-white rounded-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Save for later">
                                        <span class="flaticon-valentine-heart"></span>
                                      </button>
                                    </div>
                                    <div class="position-absolute bottom-0 left-0 right-0">
                                        <div class="px-3 pb-2">
                                            <h2 class="h5 text-white mb-0 font-weight-bold"><small class="mr-2">@lang('home.from')</small>${{ $item->price }}.00</h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body px-4 py-2">
                                    <a href="{{ url('single-product/'.$item->id) }}" class="d-block">
                                        <div class="mb-1 d-flex font-size-14 text-gray-1 justify-content-center">
                                            {{ $item->name_urdu }}
                                        </div>
                                    </a>
                                    <a href="{{ url('add-cart/'.$item->id) }}" class="card-title font-size-17 font-weight-bold mb-0 text-light btn btn-success btn-block">@lang('home.add_cart')</a>
                                </div>
                            </div>
                        	</div>
                        @endif
                        @endforeach

                        @elseif(app()->getLocale() == 'ur')
                            @foreach($products as $item)
                                @if($value1->id == $item->category_id)
                                    <div class="col-md-6 col-lg-4 col-xl-3 mb-3 mb-md-4 pb-1">
                                    <div class="card mb-1 transition-3d-hover shadow-hover-2 tab-card h-100">
                                        <div class="position-relative mb-2">
                                            <a href="{{ url('single-product/'.$item->id) }}" class="d-block gradient-overlay-half-bg-gradient-v5">
                                                <img class="card-img-top" src="{{ $item->image->url) }}" alt="img">
                                            </a>
                                            <div class="position-absolute top-0 right-0 pt-5 pr-3">
                                              <button type="button" class="btn btn-sm btn-icon text-white rounded-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Save for later">
                                                <span class="flaticon-valentine-heart"></span>
                                              </button>
                                            </div>
                                            <div class="position-absolute bottom-0 left-0 right-0">
                                                <div class="px-3 pb-2">
                                                    <h2 class="h5 text-white mb-0 font-weight-bold"><small class="mr-2">@lang('home.from')</small>${{ $item->price }}.00</h2>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body px-4 py-2">
                                            <a href="{{ url('single-product/'.$item->id) }}" class="d-block">
                                                <div class="mb-1 d-flex font-size-14 text-gray-1 justify-content-center">
                                                    {{ $item->name_arabic }}
                                                </div>
                                            </a>
                                            <a href="{{ url('add-cart/'.$item->id) }}" class="card-title font-size-17 font-weight-bold mb-0 text-light btn btn-success btn-block">@lang('home.add_cart')</a>
                                        </div>
                                    </div>
                                    </div>
                                @endif
                            @endforeach
                        @else
                            @foreach($products as $item)
                                @if($value1->id == $item->category_id)
                                    <div class="col-md-6 col-lg-4 col-xl-3 mb-3 mb-md-4 pb-1">
                                    <div class="card mb-1 transition-3d-hover shadow-hover-2 tab-card h-100">
                                        <div class="position-relative mb-2">
                                            <a href="{{ url('single-product/'.$item->id) }}" class="d-block gradient-overlay-half-bg-gradient-v5">
                                                <img class="card-img-top" src="{{ $item->image->url) }}" alt="img">
                                            </a>
                                            <div class="position-absolute top-0 right-0 pt-5 pr-3">
                                              <button type="button" class="btn btn-sm btn-icon text-white rounded-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Save for later">
                                                <span class="flaticon-valentine-heart"></span>
                                              </button>
                                            </div>
                                            <div class="position-absolute bottom-0 left-0 right-0">
                                                <div class="px-3 pb-2">
                                                    <h2 class="h5 text-white mb-0 font-weight-bold"><small class="mr-2">@lang('home.from')</small>${{ $item->price }}.00</h2>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body px-4 py-2">
                                            <a href="{{ url('single-product/'.$item->id) }}" class="d-block">
                                                <div class="mb-1 d-flex font-size-14 text-gray-1 justify-content-center">
                                                    {{ $item->name }}
                                                </div>
                                            </a>
                                            <a href="{{ url('add-cart/'.$item->id) }}" class="card-title font-size-17 font-weight-bold mb-0 text-light btn btn-success btn-block">@lang('home.add_cart')</a>
                                        </div>
                                    </div>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div> --}}
    <!-- End Tabs v1 -->


<!--add any things hereeeeeeeeeeeeeeeeeeee-->



    <!-- Banner v1-->
    



    
        
        <style>
            /* تنسيق الحاوية الرئيسية */
.container {
    width: 80%;
    margin: 0 auto;
    
    
}

/* تنسيق ال info */
.info {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap; /* السماح بالتفاف العناصر عند الحاجة */
    gap: 20px; /* إضافة فراغ بين العناصر */
    text-align: center;
    font-weight: bold; /* جعل النص في المنتصف أسفل الأيقونات */
}
.look{
    margin-bottom: 70px
}

/* تنسيق كل بطاقة */
.card-info-wrapper {
    width: 22%;   
    height: auto;
    background-color: ##f9f9f900; /* لون الخلفية لكل card */
    border-radius: 10px; /* إضافة حواف دائرية */
    padding: 20px;
    box-shadow: 0 4px 8px rgb(0 0 0 / 5%); /* إضافة ظل خفيف */
    transition: transform 0.3s ease-in-out;

}

.card-info-wrapper:hover {
    transform: scale(1.05); /* تكبير العنصر عند التمرير عليه */
}

/* تنسيق الأيقونات والأرقام */
.card-info {
    display: flex;
    flex-direction: row-reverse; /* جعل الأيقونة على اليمين */
    justify-content: space-between;
    align-items: center; /* جعل المحتويات في منتصف المحور الرأسي */
    font-size: 20px;
}

.card-info i, .card-info span {
    padding: 10px;
    font-size: 24px;
}

.card-info i {
    color:  #833ab4; /* لون الأيقونة */
}

.card-info span {
    font-weight: bold;
    font-size: 28px; /* تكبير الرقم */
}

/* النص تحت الأرقام */
.card-info-wrapper p {
    margin-top: 10px;
    font-size: 16px;
    color: #555;
}
.header h2{
        text-align: center ;
        font-weight: bold;
      

    }
    .header{
        margin-top:70px; 
        margin-bottom:70px; 
    }
    .icon-card {
    height: 100%; /* يجعل العنصر يأخذ 100% من ارتفاع العمود */
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 20px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.icon-card img {
    width: 80px; /* تكبير الصور قليلاً */
    height: 80px;
    transition: opacity 0.3s ease, transform 0.3s ease;
}

.icon-card img:hover {
    opacity: 0.9;
    transform: scale(1.1); /* تكبير الصورة عند التمرير عليها */
}

.icon-card:hover {
    transform: translateY(-5px); /* تحريك العنصر لأعلى قليلاً عند التمرير */
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
}
.just{
    margin-bottom: 50px
}

/* Media Queries لجعل التصميم متجاوب */

/* للشاشات المتوسطة والصغيرة (أقل من 992px) */
@media (max-width: 992px) {
    .card-info-wrapper {
        width: 45%; /* عرض 2 بطاقات جنب بعض */
    }
}

/* للشاشات الصغيرة جدًا (أقل من 768px) */
@media (max-width: 768px) {
    .card-info-wrapper {
        width: 100%; /* بطاقة واحدة في كل صف */
    }
}

/* للشاشات الصغيرة جدًا جدًا (أقل من 576px) */
@media (max-width: 576px) {
    .card-info-wrapper {
        width: 100%; /* بطاقة واحدة في كل صف */
    }

    .card-info i, .card-info span {
        font-size: 20px; /* تصغير حجم الأيقونة والنص في الشاشات الصغيرة جدًا */
    }

    .card-info span {
        font-size: 24px;
    }
  
}

       
           
  
        </style>

        
     
<!--<div class="max-width-650 mx-auto text-center mt-xl-5 mb-xl-2 px-3 px-md-0">-->
            
         
<div class="look">
    <div class="header">
        <h2 class="section-title text-black font-size-30 font-weight-bold mb-0">@lang('home.Statistics')</h2>
    </div>
    <div class="slider1 space-bottom-1 space-top-lg-12 background-image container">
        <div class="info">
            <!-- المستخدمين -->
            <div class="card-info-wrapper">
                <div class="card-info">
                    <span>{{ \App\Models\User::count() }}</span>
                    <i class="fa-solid fa-users"></i>
                </div>
                <p> @lang('home.Number_User')</p>
            </div>
    
            <!-- الرحلات -->
            <div class="card-info-wrapper">
                <div class="card-info">
                    <span>{{ \App\Models\Trip::count() }}</span>
                    <i class="fa-solid fa-suitcase"></i>
                </div>
                <p>  @lang('home.Number_of_trips')</p>
            </div>
    
            <!-- المدن والمناطق -->
            <div class="card-info-wrapper">
                <div class="card-info">
                    <span>{{ \App\Models\State::count() + \App\Models\City::count() }}</span>
                    <i class="fa-solid fa-city"></i>
                </div>
                <p>
                    
                 @lang('home.Numberـofـcitiesـandـregions')</p>
            </div>
    
            <!-- المركبات -->
            <div class="card-info-wrapper">
                <div class="card-info">
                    <span>{{ \App\Models\Car::count() }}</span>
                    <i class="fa-solid fa-car-side"></i>
                </div>
                <p>@lang('home.Vehicles-count')</p>
            </div>
        </div>
    </div>
    
        
    </div>
    

 


   

       
<!--</div>-->
    
 
</div>
    
    <!-- End Banner v1-->

    <!-- Icon Block v1 -->
    <div class="icon-block-center icon-center-v1  border-color-8 " style=",
    margin-bottom: 70px;
    margin-bottom: 70px;
    ">
        <div class="container text-center space-1">
            <!-- Title -->
            <div class="w-md-80 w-lg-50 text-center mx-md-auto pb-1 mt-3">
                <h2 class="section-title text-black font-size-30 font-weight-bold">@lang('home.why_choose')</h2>
            </div>
            <!-- End Title -->

            <!-- Features -->
            <div class="mb-2 just">
                <div class="row text-center justify-content-center">
                    <!-- Icon Block 1 -->
                    <div class="col-md-4 mb-4">
                        <div class="icon-card p-4 shadow-sm rounded d-flex flex-column align-items-center h-100">
                            <img class="w-100 h-100 mb-3 " src="{{ asset('front/assets/img/80x80/price.jpeg') }}" alt="Competitive Pricing">
                            <p class="text-dark font-weight-bold">@lang('home.competitive_pricing_data')</p>
                        </div>
                    </div>
                    <!-- End Icon Block 1 -->
                
                    <!-- Icon Block 2 -->
                    <div class="col-md-4 mb-4">
                        <div class="icon-card p-4 shadow-sm rounded d-flex flex-column align-items-center h-100">
                            <img class="w-100 h-100 mb-3 " src="{{ asset('front/assets/img/80x80/award.jpeg') }}" alt="Award Winning Service">
                            <p class="text-dark font-weight-bold">@lang('home.award_winning_service_data')</p>
                        </div>
                    </div>
                    <!-- End Icon Block 2 -->
                
                    <!-- Icon Block 3 -->
                    <div class="col-md-4 mb-4">
                        <div class="icon-card p-4 shadow-sm rounded d-flex flex-column align-items-center h-100">
                            <img class="w-100 h-100 mb-3  " src="{{ asset('front/assets/img/80x80/worldwide.jpeg') }}" alt="Worldwide Coverage">
                            <p class="text-dark font-weight-bold">@lang('home.worldwide_coverage_data')</p>
                        </div>
                    </div>
                    <!-- End Icon Block 3 -->
                </div>
                
                
            </div>
            <!-- End Features -->
        </div>
    </div>
    <!-- End Icon Block v1 -->


</main>
    <div class="modal fade" id="empModal" role="dialog">
    <div class="modal-dialog">

     <!-- Modal content-->
     <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Feature Description</h3>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">

      </div>
      <div class="modal-footer">
       <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
     </div>
    </div>
    </div>
@endsection
@section('front-additional-js')

<script type="text/javascript">
    var main_url = "{{ env("MAIN_HOST_URL") }}";
    var locale = "{{ app()->getLocale() }}";

   $(function() {

        var images = "<?php echo $arr_images; ?>";
        var slider_images = images.split(',');

        $('.backgrounds').css({'background-image': 'url('+main_url + slider_images[Math.floor(Math.random() * slider_images.length)] + ')'});
   });
</script>

<script type="text/javascript">

    function openTab(id){
        $('.product-section').hide();
        $('#tab'+id).show();
    }

    $(".features").change(function(e){
        e.preventDefault();
        var feature_id = $(this).val();

        if(locale == 'en'){
              var url = main_url+"/ajax-get-feature";
          }else{
              var url = main_url+'/'+locale+"/ajax-get-feature";
          }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type:'POST',

            url:url,

            data:{
                feature_id:feature_id,
            },

            success:function(data){
                // Add response in Modal body
                $('.modal-body').html(data.feature.note);

                // Display Modal
                $('#empModal').modal('show');
            }
        });
    });

    // setTimeout(() => {
    //     $('.js-range-datepicker').flatpickr({
    //         dateFormat: 'm.d.Y',
    //         locale: {
    //             firstDayOfWeek: 1,
    //             weekdays: {
    //                 shorthand: ["أحد", "اثنين", "ثلاثاء", "أربعاء", "خميس", "جمعة", "سبت"],
    //                 longhand: ["الأحد", "الاثنين", "الثلاثاء", "الأربعاء", "الخميس", "الجمعة", "السبت"]
    //             },
    //             months: {
    //                 shorthand: ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12"],
    //                 longhand: ["يناير", "فبراير", "مارس", "أبريل", "مايو", "يونيو", "يوليو", "أغسطس", "سبتمبر", "أكتوبر", "نوفمبر", "ديسمبر"]
    //             }
    //         },
    //     });
    // }, 1000);
  
</script>
@endsection
