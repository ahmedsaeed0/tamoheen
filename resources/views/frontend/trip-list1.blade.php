@extends('layouts.front.master')
@section('title')
Trip List
@endsection
@section('front-additional-css')

@endsection
@section('content')
@include('layouts.front.include.header1')
<main id="content" role="main">
    <div class="container pt-5 pt-xl-8">
        <div class="row mb-5 mb-md-8 mt-xl-1 pb-md-1">
            <div class="col-lg-4 col-xl-3 order-lg-1 width-md-50">
                <div class="navbar-expand-lg navbar-expand-lg-collapse-block">
                    <button class="btn d-lg-none mb-5 p-0 collapsed" type="button" data-toggle="collapse" data-target="#sidebar" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="far fa-caret-square-down text-primary font-size-20 card-btn-arrow ml-0"></i>
                        <span class="text-primary ml-2">@lang('content.sidebar')</span>
                    </button>
                    <div id="sidebar" class="collapse navbar-collapse">
                        <div class="mb-6 w-100">
                            <div class="pb-4 mb-2">
                                <div class="sidebar border border-color-1 rounded-xs">
                                    <div class="p-4 mx-1 mb-1">
                                        <form class="js-validate" action="{{ url('trip-list') }}" method="GET">
                                        @csrf
                                        <!-- Input -->
                                        <span class="d-block text-gray-1  font-weight-normal mb-0 text-left">@lang('content.from')</span>
                                        <div class="mb-4">
                                            <div class="input-group border-bottom border-width-2 border-color-1">
                                            <select class="js-select selectpicker dropdown-select tab-dropdown col-12 pl-0 flaticon-pin-1 d-flex align-items-center text-primary font-weight-semi-bold" title="@lang('content.from')"
                                            data-style=""
                                            data-live-search="true"
                                            data-searchbox-classes="input-group-sm" name="city_from">
                                                @if(app()->getLocale() == 'ur')
                                                    @foreach($cities as $city)
                                                    <option class="border-bottom border-color-1" value="{{ $city->id }}" data-content='
                                                        <span class="d-flex align-items-center">
                                                            <span class="font-size-16">{{ $city->name_urdu }}</span>
                                                        </span>'>
                                                        {{ $city->name_urdu }}
                                                    </option>
                                                    @endforeach
                                                @elseif(app()->getLocale() == 'ar')
                                                    @foreach($cities as $city)
                                                    <option class="border-bottom border-color-1" value="{{ $city->id }}" data-content='
                                                        <span class="d-flex align-items-center">
                                                            <span class="font-size-16">{{ $city->name_arabic }}</span>
                                                        </span>'>
                                                        {{ $city->name_arabic }}
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
                                            </div>
                                        </div>
                                        <!-- End Input -->
                                        <span class="d-block text-gray-1  font-weight-normal mb-0 text-left">@lang('content.destination')</span>
                                        <div class="mb-4">
                                            <div class="input-group border-bottom border-width-2 border-color-1">
                                            <select class="js-select selectpicker dropdown-select tab-dropdown col-12 pl-0 flaticon-pin-1 d-flex align-items-center text-primary font-weight-semi-bold" title="@lang('content.destination')"
                                            data-style=""
                                            data-live-search="true"
                                            data-searchbox-classes="input-group-sm" name="city_to">
                                                 @if(app()->getLocale() == 'ur')
                                                    @foreach($cities as $city)
                                                    <option class="border-bottom border-color-1" value="{{ $city->id }}" data-content='
                                                        <span class="d-flex align-items-center">
                                                            <span class="font-size-16">{{ $city->name_urdu }}</span>
                                                        </span>'>
                                                        {{ $city->name_urdu }}
                                                    </option>
                                                    @endforeach
                                                @elseif(app()->getLocale() == 'ar')
                                                    @foreach($cities as $city)
                                                    <option class="border-bottom border-color-1" value="{{ $city->id }}" data-content='
                                                        <span class="d-flex align-items-center">
                                                            <span class="font-size-16">{{ $city->name_arabic }}</span>
                                                        </span>'>
                                                        {{ $city->name_arabic }}
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
                                            </div>
                                        </div>
                                        <!-- Input -->
                                        <span class="d-block text-gray-1 text-left font-weight-normal mb-0">@lang('content.trip_date')</span>
                                        <div class="border-bottom border-width-2 border-color-1">
                                            <div id="datepickerWrapperFromOne" class="u-datepicker input-group">
                                                <div class="input-group-prepend">
                                                    <span class="d-flex align-items-center mr-2">
                                                      <i class="flaticon-calendar text-primary font-weight-semi-bold"></i>
                                                    </span>
                                                </div>
                                                 <input name="date" class="js-range-datepicker font-size-16 shadow-none font-weight-medium form-control hero-form bg-transparent  border-0" type="date"
                                                     data-rp-wrapper="#datepickerWrapperFromOne"
                                                     data-rp-type="single"
                                                     data-rp-date-format="M d Y"
                                                     data-rp-default-date='["Jul 7 2020"]'>
                                            </div>
                                             <!-- End Datepicker -->
                                        </div>
                                        <!-- End Input -->

                                        <div class="col dropdown-custom px-0 mb-5">
                                            <!-- Input -->
                                            <span class="d-block text-gray-1 text-left font-weight-normal mb-2">@lang('content.person')</span>
                                        <select class="js-select selectpicker dropdown-select tab-dropdown col-12 pl-0 flaticon-pin-1 d-flex align-items-center text-primary font-weight-semi-bold" title="@lang('content.person')"
                                            data-style=""
                                            data-live-search="true"
                                            data-searchbox-classes="input-group-sm" name="number_of_person">
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
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary height-60 w-100 font-weight-bold mb-xl-0 mb-lg-1 transition-3d-hover"><i class="flaticon-magnifying-glass mr-2 font-size-17"></i>@lang('content.search')</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="pb-4 mb-2">
                                <a href="https://goo.gl/maps/kCVqYkjHX3XvoC4B9" class="d-block border border-color-1 rounded-xs">
                                    <img src="{{ asset('front/assets/img/map-markers/map.jpg') }}" alt="" width="100%">
                                </a>
                            </div> --}}

                           {{--  <div class="sidenav border border-color-8 rounded-xs">
                                <!-- Accordiaon -->
                                <div id="shopRatingAccordion" class="accordion rounded-0 shadow-none border-bottom">
                                    <div class="border-0">
                                        <div class="card-collapse" id="shopCategoryHeadingOne">
                                            <h3 class="mb-0">
                                                <button type="button" class="btn btn-link btn-block card-btn py-2 px-5 text-lh-3 collapsed" data-toggle="collapse" data-target="#shopRatingOne" aria-expanded="false" aria-controls="shopRatingOne">
                                                    <span class="row align-items-center">
                                                        <span class="col-9">
                                                            <span class="d-block font-size-lg-15 font-size-17 font-weight-bold text-dark text-lh-1dot4">Star Ratings</span>
                                                        </span>
                                                        <span class="col-3 text-right">
                                                            <span class="card-btn-arrow">
                                                                <span class="fas fa-chevron-down small"></span>
                                                            </span>
                                                        </span>
                                                    </span>
                                                </button>
                                            </h3>
                                        </div>
                                        <div id="shopRatingOne" class="collapse show" aria-labelledby="shopCategoryHeadingOne" data-parent="#shopRatingAccordion">
                                            <div class="card-body pt-0 mt-1 px-5">
                                                <!-- Checkboxes -->
                                                <div class="form-group font-size-14 text-lh-md text-secondary mb-3">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="brandAdidas">
                                                        <label class="custom-control-label text-lh-inherit text-color-1" for="brandAdidas">
                                                            <div class="d-inline-flex align-items-center font-size-13 text-lh-1 text-primary">
                                                                <div class="green-lighter ml-1 letter-spacing-2">
                                                                    <i class="fas fa-star"></i>
                                                                    <i class="fas fa-star"></i>
                                                                    <i class="fas fa-star"></i>
                                                                    <i class="fas fa-star"></i>
                                                                    <i class="fas fa-star"></i>
                                                                </div>
                                                            </div>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group font-size-14 text-lh-md text-secondary mb-3">
                                                    <div class="custom-control custom-checkbox">
                                                       <input type="checkbox" class="custom-control-input" id="brandNewBalance">
                                                       <label class="custom-control-label text-lh-inherit text-color-1" for="brandNewBalance">
                                                            <div class="d-inline-flex align-items-center font-size-13 text-lh-1 text-primary">
                                                                <div class="green-lighter ml-1 letter-spacing-2">
                                                                    <i class="fas fa-star"></i>
                                                                    <i class="fas fa-star"></i>
                                                                    <i class="fas fa-star"></i>
                                                                    <i class="fas fa-star"></i>
                                                                </div>
                                                            </div>
                                                       </label>
                                                    </div>
                                                </div>
                                                <div class="form-group font-size-14 text-lh-md text-secondary mb-3">
                                                    <div class="custom-control custom-checkbox">
                                                      <input type="checkbox" class="custom-control-input" id="brandNike">
                                                      <label class="custom-control-label text-lh-inherit text-color-1" for="brandNike">
                                                            <div class="d-inline-flex align-items-center font-size-13 text-lh-1 text-primary">
                                                                <div class="green-lighter ml-1 letter-spacing-2">
                                                                    <i class="fas fa-star"></i>
                                                                    <i class="fas fa-star"></i>
                                                                    <i class="fas fa-star"></i>
                                                                </div>
                                                            </div>
                                                      </label>
                                                    </div>
                                                </div>
                                                <div class="form-group font-size-14 text-lh-md text-secondary mb-3">
                                                    <div class="custom-control custom-checkbox">
                                                      <input type="checkbox" class="custom-control-input" id="brandFredPerry">
                                                      <label class="custom-control-label text-lh-inherit text-color-1" for="brandFredPerry">
                                                            <div class="d-inline-flex align-items-center font-size-13 text-lh-1 text-primary">
                                                                <div class="green-lighter ml-1 letter-spacing-2">
                                                                    <i class="fas fa-star"></i>
                                                                    <i class="fas fa-star"></i>
                                                                </div>
                                                            </div>
                                                      </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="shopCartAccordion" class="accordion rounded shadow-none">
                                    <div class="border-0">
                                        <div class="card-collapse" id="shopCardHeadingOne">
                                            <h3 class="mb-0">
                                                <button type="button" class="btn btn-link btn-block card-btn py-2 px-5 text-lh-3 collapsed" data-toggle="collapse" data-target="#shopCardOne" aria-expanded="false" aria-controls="shopCardOne">
                                                    <span class="row align-items-center">
                                                        <span class="col-9">
                                                            <span class="d-block font-size-lg-15 font-size-17 font-weight-bold text-dark">Price Range ($)</span>
                                                        </span>
                                                        <span class="col-3 text-right">
                                                            <span class="card-btn-arrow">
                                                                <span class="fas fa-chevron-down small"></span>
                                                            </span>
                                                        </span>
                                                    </span>
                                                </button>
                                            </h3>
                                        </div>
                                        <div id="shopCardOne" class="collapse show" aria-labelledby="shopCardHeadingOne" data-parent="#shopCartAccordion">
                                            <div class="card-body pt-0 px-5">
                                                <div class="pb-3 mb-1 d-flex text-lh-1">
                                                    <span>£</span>
                                                    <span id="rangeSliderExample3MinResult" class=""></span>
                                                    <span class="mx-0dot5"> — </span>
                                                    <span>£</span>
                                                    <span id="rangeSliderExample3MaxResult" class=""></span>
                                                </div>
                                                <input class="js-range-slider" type="text"
                                                data-extra-classes="u-range-slider height-35"
                                                data-type="double"
                                                data-grid="false"
                                                data-hide-from-to="true"
                                                data-min="0"
                                                data-max="3456"
                                                data-from="200"
                                                data-to="3456"
                                                data-prefix="$"
                                                data-result-min="#rangeSliderExample3MinResult"
                                                data-result-max="#rangeSliderExample3MaxResult">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Accordion -->
                                <div id="cityCategoryAccordion" class="accordion rounded-0 shadow-none border-top">
                                    <div class="border-0">
                                        <div class="card-collapse" id="cityCategoryHeadingOne">
                                            <h3 class="mb-0">
                                                <button type="button" class="btn btn-link btn-block card-btn py-2 px-5 text-lh-3 collapsed" data-toggle="collapse" data-target="#cityCategoryOne" aria-expanded="false" aria-controls="cityCategoryOne">
                                                    <span class="row align-items-center">
                                                        <span class="col-9">
                                                            <span class="font-weight-bold font-size-17 text-dark mb-3">City</span>
                                                        </span>
                                                        <span class="col-3 text-right">
                                                            <span class="card-btn-arrow">
                                                                <span class="fas fa-chevron-down small"></span>
                                                            </span>
                                                        </span>
                                                    </span>
                                                </button>
                                            </h3>
                                        </div>
                                        <div id="cityCategoryOne" class="collapse show" aria-labelledby="cityCategoryHeadingOne" data-parent="#cityCategoryAccordion">
                                            <div class="card-body pt-0 mt-1 px-5 pb-4">
                                                <div class="form-group d-flex align-items-center justify-content-between font-size-1 text-lh-md text-secondary mb-3">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="brandamsterdam">
                                                        <label class="custom-control-label" for="brandamsterdam">Amsterdam</label>
                                                    </div>
                                                    <span>749</span>
                                                </div>
                                                <div class="form-group d-flex align-items-center justify-content-between font-size-1 text-lh-md text-secondary mb-3">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="brandrotterdam">
                                                        <label class="custom-control-label" for="brandrotterdam">Rotterdam</label>
                                                    </div>
                                                    <span>630</span>
                                                </div>
                                                <div class="form-group d-flex align-items-center justify-content-between font-size-1 text-lh-md text-secondary mb-3">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="brandvalkenburg">
                                                        <label class="custom-control-label" for="brandvalkenburg">Valkenburg</label>
                                                    </div>
                                                    <span>58</span>
                                                </div>
                                                <div class="form-group d-flex align-items-center justify-content-between font-size-1 text-lh-md text-secondary mb-3">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="brandeindhoven">
                                                        <label class="custom-control-label" for="brandeindhoven">Eindhoven</label>
                                                    </div>
                                                    <span>29</span>
                                                </div>
                                                <!-- End Checkboxes -->

                                                <!-- View More - Collapse -->
                                                <div class="collapse" id="collapseBrand3">
                                                    <div class="form-group d-flex align-items-center justify-content-between font-size-1 text-lh-md text-secondary mb-3">
                                                        <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="gucci">
                                                        <label class="custom-control-label" for="gucci">Gucci</label>
                                                        </div>
                                                        <span>5</span>
                                                    </div>
                                                    <div class="form-group d-flex align-items-center justify-content-between font-size-1 text-lh-md text-secondary mb-3">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="mango">
                                                            <label class="custom-control-label" for="mango">Mango</label>
                                                        </div>
                                                        <span>1</span>
                                                    </div>
                                                </div>
                                                <!-- End View More - Collapse -->

                                                <!-- Link -->
                                                <a class="link link-collapse small font-size-1 mt-2" data-toggle="collapse" href="#collapseBrand3" role="button" aria-expanded="false" aria-controls="collapseBrand3">
                                                  <span class="link-collapse__default font-size-14">Show all 25</span>
                                                  <span class="link-collapse__active font-size-14">Show less</span>
                                                </a>
                                                <!-- End Link -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Accordion -->
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-xl-9 order-md-1 order-lg-2">
                <!-- Shop-control-bar Title -->
                {{-- <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="font-size-21 font-weight-bold mb-0 text-lh-1">London: 3292 tours found</h3>
                    <ul class="nav tab-nav-shop flex-nowrap" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link font-size-22 p-0" id="pills-three-example1-tab" data-toggle="pill" href="#pills-three-example1" role="tab" aria-controls="pills-three-example1" aria-selected="true">
                                <div class="d-md-flex justify-content-md-center align-items-md-center">
                                    <i class="fa fa-list"></i>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link font-size-22 p-0 ml-2 active" id="pills-one-example1-tab" data-toggle="pill" href="#pills-one-example1" role="tab" aria-controls="pills-one-example1" aria-selected="false">
                                <div class="d-md-flex justify-content-md-center align-items-md-center">
                                    <i class="fa fa-th"></i>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div> --}}
                <!-- End shop-control-bar Title -->

                <!-- Slick Tab carousel -->
                <div class="u-slick__tab">

                    <!-- Tab Content -->
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-one-example1" role="tabpanel" aria-labelledby="pills-one-example1-tab" data-target-group="groups">
                            <div class="row">
                                @if(count($trips) > 0)
                                @foreach($trips as $trip)
                                <div class="col-md-6 col-xl-4 mb-3 mb-md-4 pb-1">
                                    <div class="card mb-1 transition-3d-hover shadow-hover-2 tab-card h-100">
                                        <div class="position-relative mb-2">
                                            <a href="{{ url('single-trip/'.$trip->id) }}" class="d-block gradient-overlay-half-bg-gradient-v5">
                                                @foreach($trip->cars->images as $key => $img)
                                                <img class="min-height-230 bg-img-hero card-img-top" src="{{ asset('storage/'.$img->url) }}" alt="img">
                                                @endforeach
                                            </a>
                                            <div class="position-absolute top-0 left-0 pt-5 pl-3">
                                                {{-- <span class="badge badge-pill bg-white text-primary px-4 py-2 font-size-14 font-weight-normal">Featured</span>
                                                <span class="badge badge-pill bg-white text-danger px-3 ml-3 py-2 font-size-14 font-weight-normal">%25</span> --}}
                                            </div>
                                            <div class="position-absolute top-0 right-0 pt-5 pr-3">
                                              <button type="button" class="btn btn-sm btn-icon text-white rounded-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Save for later">
                                                <span class="flaticon-valentine-heart font-size-20"></span>
                                              </button>
                                            </div>
                                            <div class="position-absolute bottom-0 left-0 right-0">
                                                <div class="px-3 pb-2">
                                                    <h2 class="h5 text-white mb-0 font-weight-bold"><small class="mr-2">@lang('content.from')</small>${{ $trip->price_per_person }}</h2>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body px-4 py-2">
                                            <a href="{{ url('single-trip/'.$trip->id) }}" class="d-block">
                                                <div class="mb-1 d-flex align-items-center font-size-14 text-gray-1">
                                                    <i class="icon flaticon-pin-1 mr-2 font-size-15"></i> {{ $trip->pickup_location }}
                                                </div>
                                            </a>
                                            <a href="{{ url('single-trip/'.$trip->id) }}" class="card-title font-size-17 font-weight-bold mb-0 text-dark">{{ $trip->pickup_location }}</a>
                                            {{-- <div class="my-2">
                                                <div class="d-inline-flex align-items-center font-size-17 text-lh-1 text-primary">
                                                    <div class="green-lighter mr-2">
                                                        <small class="fas fa-star"></small>
                                                        <small class="fas fa-star"></small>
                                                        <small class="fas fa-star"></small>
                                                        <small class="fas fa-star"></small>
                                                        <small class="fas fa-star"></small>
                                                    </div>
                                                    <span class="text-secondary font-size-14 mt-1">48 Reviews</span>
                                                </div>
                                            </div>
                                            <div class="mb-1 d-flex align-items-center font-size-14 text-gray-1">
                                                <i class="icon flaticon-clock-circular-outline mr-2 font-size-14"></i> 3 hours 45 minutes
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @else
                                    <h3 class="text-center text-danger">@lang('content.no_trip_found')....</h3>
                                @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Tab Content -->
                    {{-- <div class="text-center text-md-left font-size-14 mb-3 text-lh-1">Showing 1–15</div> --}}
                        {{-- <nav aria-label="Page navigation">
                            <ul class="list-pagination-1 pagination border border-color-4 rounded-sm overflow-auto overflow-xl-visible justify-content-md-center align-items-center py-2 mb-0">
                                <li class="page-item">
                                    <a class="page-link border-right rounded-0 text-gray-5" href="#" aria-label="Previous">
                                        <i class="flaticon-left-direction-arrow font-size-10 font-weight-bold"></i>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                </li>
                                <li class="page-item"><a class="page-link font-size-14" href="#">1</a></li>
                                <li class="page-item"><a class="page-link font-size-14 active" href="#">2</a></li>
                                <li class="page-item"><a class="page-link font-size-14" href="#">3</a></li>
                                <li class="page-item"><a class="page-link font-size-14" href="#">4</a></li>
                                <li class="page-item"><a class="page-link font-size-14" href="#">5</a></li>
                                <li class="page-item disabled"><a class="page-link font-size-14" href="#">...</a></li>
                                <li class="page-item"><a class="page-link font-size-14" href="#">66</a></li>
                                <li class="page-item"><a class="page-link font-size-14" href="#">67</a></li>
                                <li class="page-item">
                                    <a class="page-link border-left rounded-0 text-gray-5" href="#" aria-label="Next">
                                        <i class="flaticon-right-thin-chevron font-size-10 font-weight-bold"></i>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </li>
                            </ul>
                        </nav> --}}
                    </div>
                </div>
                <!-- Slick Tab carousel -->
            </div>
        </div>
    </div>
</main>
@endsection
@section('front-additional-js')
@endsection