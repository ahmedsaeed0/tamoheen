@extends('layouts.front.master')
@section('title')
Ship Trip List
@endsection
@section('front-additional-css')
<style type="text/css">
    /*body {
      background-color:  #eee;
    }*/
    .title {
     
        margin-bottom: 50px;
        text-transform: uppercase;
    }

    .card-block {
        font-size: 1em;
        position: relative;
        margin: 0;
        padding: 1em;
        border: none;
        border-top: 1px solid rgba(34, 36, 38, .1);
        box-shadow: none;
         
    }
    .card {
        font-size: 1em;
        overflow: hidden;
        padding: 5;
        border: none;
        border-radius: .28571429rem;
        box-shadow: 0 1px 3px 0 #d4d4d5, 0 0 0 1px #d4d4d5;
        margin-top:20px;
    }

    .carousel-indicators li {
        border-radius: 12px;
        width: 12px;
        height: 12px;
        background-color: #404040;
    }
    .carousel-indicators li {
        border-radius: 12px;
        width: 12px;
        height: 12px;
        background-color: #404040;
    }
    .carousel-indicators .active {
        background-color: white;
        max-width: 12px;
        margin: 0 3px;
        height: 12px;
    }
    .carousel-control-prev-icon {
     background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%23fff' viewBox='0 0 8 8'%3E%3Cpath d='M5.25 0l-4 4 4 4 1.5-1.5-2.5-2.5 2.5-2.5-1.5-1.5z'/%3E%3C/svg%3E") !important;
    }

    .carousel-control-next-icon {
      background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%23fff' viewBox='0 0 8 8'%3E%3Cpath d='M2.75 0l-1.5 1.5 2.5 2.5-2.5 2.5 1.5 1.5 4-4-4-4z'/%3E%3C/svg%3E") !important;
    }
      

    .btn {
      margin-top: auto;
    }

    .card-block p{
        line-height: 1;
    }
</style>
@endsection
@section('content')
@include('layouts.front.include.header1')
<main id="content" role="main">
    <div class="gallery-slider">
      
        <!-- __images -->
      
        <div class="gallery-slider__images">
          <div>
          @foreach($to_city->images as $key => $img)   <!-- .item -->
            <div class="item">
            <div class="img-fill"><img  src="{{ asset('storage/'.$img->url) }}" alt="{{ $to_city->name }}"></div>
            </div>
          @endforeach
            <!-- /.item -->
            
            <!-- /.item -->
          </div>
          <button class="prev-arrow slick-arrow">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1280 1792">
              <path fill="#fff" d="M1171 301L640 832l531 531q19 19 19 45t-19 45l-166 166q-19 19-45 19t-45-19L173 877q-19-19-19-45t19-45L915 45q19-19 45-19t45 19l166 166q19 19 19 45t-19 45z" />
            </svg>
          </button>
          <button class="next-arrow slick-arrow">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1280 1792">
              <path fill="#fff" d="M1107 877l-742 742q-19 19-45 19t-45-19l-166-166q-19-19-19-45t19-45l531-531-531-531q-19-19-19-45t19-45L275 45q19-19 45-19t45 19l742 742q19 19 19 45t-19 45z" />
            </svg>
          </button>
       
        </div>
        <!-- /__images -->
    
    
        <!-- __thumbnails -->
        <div class="gallery-slider__thumbnails">
          <div>
            @foreach($to_city->images as $key => $img)
            <div class="item">
              <div class="img-fill"><img src="{{ asset('storage/'.$img->url) }}" alt=""></div>
            </div>
            @endforeach
            <!-- .item -->
          
            <!-- /.item -->
          </div>
    
          <button class="prev-arrow slick-arrow">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1280 1792">
              <path fill="#fff" d="M1171 301L640 832l531 531q19 19 19 45t-19 45l-166 166q-19 19-45 19t-45-19L173 877q-19-19-19-45t19-45L915 45q19-19 45-19t45 19l166 166q19 19 19 45t-19 45z" />
            </svg>
          </button>
          <button class="next-arrow slick-arrow">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1280 1792">
              <path fill="#fff" d="M1107 877l-742 742q-19 19-45 19t-45-19l-166-166q-19-19-19-45t19-45l531-531-531-531q-19-19-19-45t19-45L275 45q19-19 45-19t45 19l742 742q19 19 19 45t-19 45z" />
            </svg>
          </button>
        </div>
        <!-- /__thumbnails -->
    
      </div>
  
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
                                        <form class="js-validate" action="{{ url('ship-list') }}" method="GET">
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
                                                <span class="d-block text-gray-1 text-left font-weight-normal mb-2">@lang('content.number_of_bag')</span>
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
                                            </div>

                                            <div class="col dropdown-custom px-0 mb-5">
                                                <!-- Input -->
                                                <span class="d-block text-gray-1 text-left font-weight-normal mb-2">@lang('content.product_type')</span>
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
                                            </div>

                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary height-60 w-100 font-weight-bold mb-xl-0 mb-lg-1 transition-3d-hover"><i class="flaticon-magnifying-glass mr-2 font-size-17"></i>@lang('content.search')</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="sidenav border border-color-8 rounded-xs">
                                <!-- Accordiaon -->
                                <div id="shopCartAccordion" class="accordion rounded shadow-none">
                                    <div class="border-0">
                                        <div class="card-collapse" id="shopCardHeadingOne">
                                            <h3 class="mb-0">
                                                <button type="button" class="btn btn-link btn-block card-btn py-2 px-5 text-lh-3 collapsed" data-toggle="collapse" data-target="#shopCardOne" aria-expanded="false" aria-controls="shopCardOne">
                                                    <span class="row align-items-center">
                                                        <span class="col-9">
                                                            <span class="d-block font-size-lg-15 font-size-17 font-weight-bold text-dark">@lang('content.price_range') ($)</span>
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
                                        <div id="shopCardOne" class="collapse show p-4" aria-labelledby="shopCardHeadingOne" data-parent="#shopCartAccordion">
                                            <div class="card-body pt-0 px-5">
                                                <div class="pb-3 mb-1 d-flex text-lh-1">
                                                    <span>$</span>
                                                    <span id="rangeSliderExample3MinResult" class=""></span>
                                                    <span class="mx-0dot5"> — </span>
                                                    <span>$</span>
                                                    <span id="rangeSliderExample3MaxResult" class=""></span>
                                                </div>
                                                <input class="js-range-slider" type="text"
                                                data-extra-classes="u-range-slider height-35"
                                                data-type="double"
                                                data-grid="false"
                                                data-hide-from-to="true"
                                                data-min="0"
                                                data-max="3456"
                                                data-from="0"
                                                data-to="3456"
                                                data-prefix="$"
                                                data-result-min="#rangeSliderExample3MinResult"
                                                data-result-max="#rangeSliderExample3MaxResult" id="slider">
                                            </div>
                                                  {{-- <div data-role="rangeslider">
                                                    <label for="price-min">Price:</label>
                                                    <input type="range" name="price-min" id="price-min" value="200" min="0" max="1000">
                                                    <label for="price-max">Price:</label>
                                                    <input type="range" name="price-max" id="price-max" value="800" min="0" max="1000">
                                                  </div> --}}
                                        </div>
                                    </div>
                                </div>
                                <!-- End Accordion -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-xl-9 order-md-1 order-lg-2">

                <!-- Slick Tab carousel -->
                <div class="u-slick__tab">

                    <!-- Tab Content -->
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade active show" id="pills-three-example1" role="tabpanel" aria-labelledby="pills-three-example1-tab" data-target-group="groups">
                            <ul class="d-block list-unstyled products-group prodcut-list-view">
                                @if(count($trips) > 0)
                                    @foreach($trips as $trip)
                                    <li class="card mb-5 overflow-hidden">
                                        <div class="product-item__outer w-100">
                                            <div class="row align-items-center">
                                                <div class="col-md-5 col-xl-4">
                                                    <div class="product-item__header">
                                                        <div class="position-relative">
                                                            <div class="js-slick-carousel u-slick u-slick--equal-height u-slick--gutters-3"
                                                                data-slides-show="1"
                                                                data-slides-scroll="1"
                                                                data-arrows-classes="d-none d-lg-inline-block u-slick__arrow-classic v4 u-slick__arrow-classic--v4 u-slick__arrow-centered--y rounded-circle"
                                                                data-arrow-left-classes="flaticon-back u-slick__arrow-classic-inner u-slick__arrow-classic-inner--left"
                                                                data-arrow-right-classes="flaticon-next u-slick__arrow-classic-inner u-slick__arrow-classic-inner--right"
                                                                data-pagi-classes="js-pagination text-center u-slick__pagination u-slick__pagination--white position-absolute right-0 bottom-0 left-0 mb-3 mb-0">
                                                                @foreach($trip->cars->images as $key => $img)
                                                                <div class="js-slide w-100">
                                                                    <a href="{{ url('single-trip/'.$trip->id) }}" class="d-block gradient-overlay-half-bg-gradient-v5 w-100">
                                                                        <img class="img-fluid min-height-230" src="{{ asset('storage/'.$img->url) }}">
                                                                    </a>
                                                                </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-7 col-xl-5 flex-horizontal-center">
                                                    <div class="w-100 position-relative m-4 m-md-0">
                                                        <div class="mb-2 pb-1">
                                                            <span class="green-lighter ml-md-2 d-block d-md-inline">
                                                                <small class="fas fa-star font-size-11"></small>
                                                                <small class="fas fa-star font-size-11"></small>
                                                                <small class="fas fa-star font-size-11"></small>
                                                                <small class="fas fa-star font-size-11"></small>
                                                                <small class="fas fa-star font-size-11"></small>
                                                            </span>
                                                        </div>

                                                        {{-- <div class="position-absolute top-0 right-0 pr-md-3 d-none d-md-block">
                                                            <button type="button" class="btn btn-sm btn-icon rounded-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Save for later">
                                                                <span class="flaticon-heart-1 font-size-20"></span>
                                                            </button>
                                                        </div> --}}
                                                        <a href="{{ url('single-trip/'.$trip->id) }}">
                                                            <span class="font-weight-bold font-size-17 text-dark d-flex mb-1">
                                                                {{ $trip->title }}
                                                            </span>
                                                        </a>
                                                        <div class="card-body p-0">
                                                            <a href="{{ url('single-trip/'.$trip->id) }}" class="d-block mb-3">
                                                                <div class="d-flex flex-wrap flex-xl-nowrap align-items-center font-size-14 text-gray-1">
                                                                    <i class="icon flaticon-placeholder mr-2 font-size-20"></i> {{ $trip->pickup_location }}
                                                                    {{-- <small class="px-1 font-size-15"> - </small>
                                                                    <span class="text-primary font-size-14">View on map</span> --}}
                                                                </div>
                                                                {{-- <div class="d-flex flex-wrap flex-xl-nowrap align-items-center font-size-14 text-gray-1">
                                                                    <span>Features: </span>
                                                                    @foreach($trip->cars->carFeatures as $feature)
                                                                    @if($feature->image != null)
                                                                    <img src="{{ asset('storage/'.$feature->image->url) }}" style="width: 20px; height: 20px;" title="{{ $feature->name }}">
                                                                    @endif
                                                                    @endforeach
                                                                </div> --}}
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col col-xl-3 align-self-center py-4 py-xl-0 border-top border-xl-top-0">
                                                    <div class="border-xl-left border-color-7">
                                                        <div class="ml-md-4 ml-xl-0">
                                                            <div class="text-center text-md-left text-xl-center d-flex flex-column mb-2 pb-1 ml-md-3 ml-xl-0">
                                                                {{-- <div class="d-flex flex-column mb-2">
                                                                    <span class="font-weight-normal font-size-14 text-gray-1 mb-2 pb-1 ml-md-2 ml-xl-0">Multi-day Tours</span>
                                                                    <span class="font-weight-normal font-size-14 text-gray-1">3 hours 45 minutes</span>
                                                                </div> --}}
                                                                <div class="mb-0">
                                                                    <span class="mr-1 font-size-14 text-gray-1">@lang('content.fromt')</span>
                                                                    @if($trip->type == 1)
                                                                    <span class="font-weight-bold font-size-22">£{{ $trip->price_per_person }}</span>
                                                                    @else
                                                                        <span class="font-weight-bold font-size-22">£{{ $trip->price_per_bag }}</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="d-flex justify-content-center justify-content-md-start justify-content-xl-center">
                                                                <a href="{{ url('single-trip/'.$trip->id) }}" class="btn btn-outline-primary d-flex align-items-center justify-content-center font-weight-bold min-height-50 border-radius-3 border-width-2 px-2 px-5 py-2">@lang('content.view_detail')</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach
                                @else
                                    <h3 class="text-center text-danger">@lang('content.no_trip_found')....</h3>
                                @endif
                            </ul>
                        </div>
                        
                    </div>
                    
                    </div>
                </div>
                <!-- Slick Tab carousel -->
            </div>
        </div>
    </div>
</main>

<!-- The Modal -->
{{-- <div class="modal" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header mx-auto d-block">
          <h4 class="modal-title">Select Your Trip</h4>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
            <div class="container">
                <a href="#" data-dismiss="modal">
                <div class="card">
                    <div class="row">
                        <div class="col-sm-5">
                            <img class="d-block w-100" src="{{ asset('front/assets/images/hijab.png') }}" alt="">
                        </div>
                        <div class="col-sm-7">
                            <div class="card-block">
                                <h3>Family Trip</h3>
                                <p>An adult male must accompany you</p>
                                
                            </div>
                        </div>
             
                    </div>
                </div>
                </a>
                <a href="#" data-dismiss="modal">
                <div class="card">
                    <div class="row">
                        <div class="col-sm-5">
                            <img class="d-block w-100" src="{{ asset('front/assets/images/male.jpg') }}" alt="">
                        </div>
                        <div class="col-sm-7">
                            <div class="card-block">
                                <h3>Individuals Trip</h3>
                                <p>An adult male must accompany you</p>
                                
                            </div>
                        </div>
             
                    </div>
                </div>
                </a>
            </div>
        </div>
        
      </div>
    </div>
</div> --}}
@endsection
@section('front-additional-js')
<script type="text/javascript">
    $(document).on('input', '#slider', function() {
       var range = $(this).val();
       var split_range = range.split(';');
       var min_price = split_range[0];
       var max_price = split_range[1];
       var base_url = "{{ url('ship-price-range-search') }}";
       var to_city_id = "{{ $to_city->id }}";
        window.location.href= base_url+'/'+min_price+'/'+max_price+'/'+to_city_id;
    });

    // $("#slider").slider({
      // slide: function (e, ui) {

      //   $(".whatis").html("dragging");
      // },

    //   stop: function (e, ui) {
    //     var range_price = $(this).val();
    //     console.log(range_price);
    //   }
    // })
</script>
@endsection