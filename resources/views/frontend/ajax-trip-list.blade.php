<style>
/* This */

* {
        box-sizing: border-box;
      }
      .mew-bg{
        background-color: red;
    padding: 2px;
    width: 194px;
    transform: rotate(45deg) !important;
    color: white;
    position: absolute;
    top: -10px;
    right: -38px;
    display:flex ;
    justify-content:center;
    align-items:center;
      }
      .overflow{
        overflow : hidden ;
      }
      .mew-bg span{
        padding-left: 71px;
      }

/* this */
</style>
<div class="container pt-5 pt-xl-8">

    <div style="display: flex;

    justify-content: space-between;

    max-width: 600px;

    margin: auto;" class="mb-3 date-bedge"  >

        @foreach ($final_seven_days as $day)

        @if(Carbon\Carbon::parse($date)->format('Y-m-d') == $day)

                <div style="cursor: pointer" class="badge badge-pill badge-success ">

                    <span class="trip-date" serial="{{ $loop->iteration }}">{{ Carbon\Carbon::parse($day)->format('d M') }}<span>

                        <input type="hidden" id="trip-date-{{ $loop->iteration }}" value="{{ Carbon\Carbon::parse($day)->format('M d Y') }}">

                </div>

            @else

                <div  style="cursor: pointer" class="badge badge-pill badge-primary">

                    <span class="trip-date" serial="{{ $loop->iteration }}">{{ Carbon\Carbon::parse($day)->format('d M') }}<span>

                        <input type="hidden" id="trip-date-{{ $loop->iteration }}" value="{{ Carbon\Carbon::parse($day)->format('M d Y') }}">

                </div>

            @endif

        @endforeach

    </div>



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



                                        <div class="col dropdown-custom px-0 mb-5">

                                            <!-- Input -->

                                            <span class="d-block text-gray-1 text-left font-weight-normal mb-2">@lang('content.main_feature')</span>

                                            <select class="select-box js-select dropdown-select tab-dropdown col-12 pl-0 flaticon-pin-1 d-flex align-items-center text-primary font-weight-semi-bold" title="@lang('content.main_feature')"

                                            data-style=""

                                            data-live-search="true"

                                            data-searchbox-classes="input-group-sm" name="feature_id" id="main-feature">

                                                @foreach($features as $key => $feature)

                                                        @if(app()->getLocale() == 'ar')

                                                            <option class="border-bottom border-color-1" value="{{ $feature->id }}" data-content='

                                                                <span class="d-flex align-items-center">

                                                                    <span class="font-size-16">{{ $feature->name_arabic }}</span>

                                                                </span>'>

                                                                {{ $feature->name_arabic }}

                                                            </option>

                                                        @elseif(app()->getLocale() == 'en')    

                                                            <option class="border-bottom border-color-1" value="{{ $feature->id }}" data-content='

                                                                <span class="d-flex align-items-center">

                                                                    <span class="font-size-16">{{ $feature->name }}</span>

                                                                </span>'>

                                                                {{ $feature->name }}

                                                            </option>

                                                        @endif                                                      

                                                @endforeach

                                            </select>

                                        </div>



                                        {{-- <div class="col dropdown-custom px-0 mb-5">

                                            <!-- Input -->

                                            <span class="d-block text-gray-1 text-left font-weight-normal mb-2 ">Car Feature</span>

                                        <select class="car-feature js-select dropdown-select tab-dropdown col-12 pl-0 flaticon-pin-1 d-flex align-items-center text-primary font-weight-semi-bold" title="Car Feature"

                                        data-style=""

                                        data-live-search="true"

                                        data-searchbox-classes="input-group-sm" name="feature_id">

                                        @foreach($features as $key => $feature)

                                                        @if(app()->getLocale() == 'ar')

                                                            <option class="border-bottom border-color-1" value="{{ $feature->id }}" data-content='

                                                                <span class="d-flex align-items-center">

                                                                    <span class="font-size-16">{{ $feature->name_arabic }}</span>

                                                                </span>'>

                                                                {{ $feature->name_arabic }}

                                                            </option>

                                                        @elseif(app()->getLocale() == 'en')    

                                                            <option class="border-bottom border-color-1" value="{{ $feature->id }}" data-content='

                                                                <span class="d-flex align-items-center">

                                                                    <span class="font-size-16">{{ $feature->name }}</span>

                                                                </span>'>

                                                                {{ $feature->name }}

                                                            </option>

                                                        @endif                                                      

                                                @endforeach

                                        </select>

                                        </div> --}}

                                    </form>

                                </div>

                            </div>

                        </div>



                        {{-- <div class="sidenav border border-color-8 rounded-xs">

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

                                    </div>

                                </div>

                            </div>

                            <!-- End Accordion -->

                        </div> --}}

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-8 col-xl-8 order-md-1 order-lg-2">



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

                                            <div class="col-md-5 col-xl-4 overflow relative p-0">
                                            @if(\Carbon\Carbon::parse($trip->date)->gt(now()))
                                                <div class="mew-bg">
                                                    <span>New</span>
                                                </div>
                                            @endif
                                                <div class="product-item__header">

                                                    <div class="position-relative">



                                                        <div class=""

                                                            data-slides-show="1"

                                                            data-slides-scroll="1"

                                                            data-arrows-classes="d-none d-lg-inline-block u-slick__arrow-classic v4 u-slick__arrow-classic--v4 u-slick__arrow-centered--y"

                                                            data-arrow-left-classes="flaticon-back u-slick__arrow-classic-inner u-slick__arrow-classic-inner--left"

                                                            data-arrow-right-classes="flaticon-next u-slick__arrow-classic-inner u-slick__arrow-classic-inner--right"

                                                            data-pagi-classes="js-pagination text-center u-slick__pagination u-slick__pagination--white position-absolute right-0 bottom-0 left-0 mb-3 mb-0">

                                                            

                                                            <div class="js-slide w-100">

                                                                <a href="{{ url('single-trip/'.$trip->id) }}" class="d-block gradient-overlay-half-bg-gradient-v5 w-100">

                                                                    @isset($trip->cars->images)

                                                                        @if($trip->cars->images->count() > 0)

                                                                            <img class="img-fluid min-height-230" src="{{ $trip->cars->images[0]->url }}">
                                                    

                                                                        @else

                                                                            <img class="img-fluid min-height-230" src="" alt="{{ $trip->title }}">

                                                                        @endif

                                                                    @endisset

                                                                </a>

                                                            </div>

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

                                                    <a href="{{ url('single-trip/'.$trip->id) }}">

                                                        <span class="font-weight-bold font-size-17 text-dark d-flex mb-1">

                                                            {{ App\Http\Controllers\FrontendsController::getBrandName($trip->user_id) }}- {{$trip->id}}

                                                        </span>

                                                    </a>

                                                    <div class="card-body p-0">

                                                        <a href="{{ url('single-trip/'.$trip->id) }}" class="d-block mb-3">

                                                            <div class="d-flex flex-wrap flex-xl-nowrap align-items-center font-size-14 text-gray-1">

                                                                <i class="icon flaticon-placeholder mr-2 font-size-20"></i> {{ $trip->pickup_location }}

                                                            </div>

                                                            <div class="d-flex flex-wrap flex-xl-nowrap align-items-center font-size-14 font-weight-bold text-gray-1">
                                                                @if($trip->available_of_person != 0 && $trip->available_of_person > 0)
                                                                    <span>@lang('content.available_person'): <span class='text-danger'>{{ $trip->available_of_person }}</span></span>
                                                                @else
                                                                    <span>@lang('content.available_person'): <span class='text-danger'>@lang('content.no_available_person')</span></span>
                                                                @endif
                                                            </div>

                                                            <div class="d-flex flex-wrap flex-xl-nowrap align-items-center font-size-14 text-gray-1">

                                                                <span>@lang('content.features'): </span>

                                                                @foreach($trip->cars->carFeatures as $feature)

                                                                @if($feature->image != null)

                                                                <img src="{{ $feature->image->url }}" style="width: 30px; height: 30px;" title="{{ $feature->name }}">

                                                                @endif

                                                                @endforeach

                                                            </div>

                                                        </a>

                                                    </div>

                                                </div>

                                            </div>

                                            <div class="col col-xl-3 align-self-center py-4 py-xl-0 border-top border-xl-top-0">

                                                <div class="border-xl-left border-color-7">

                                                    <div class="ml-md-4 ml-xl-0">

                                                        <div class="text-center text-md-left text-xl-center d-flex flex-column mb-2 pb-1 ml-md-3 ml-xl-0">

                                                            <div class="mb-0">

                                                                @if($trip->discount > 0)

                                                                    <i class="fas fa-fire text-danger font-size-22 mr-1"></i>

                                                                    {{-- <span class="mr-1 font-size-14 text-gray-1">@lang('content.from')</span> --}}

                                                                    @if($trip->type == 1)

                                                                    <span class="font-weight-bold font-size-22">SAR {{ $trip->discount }}</span>

                                                                    <span class="font-weight-bold font-size-16"><s>SAR {{ $trip->price_per_person }}</s></span>

                                                                    @else

                                                                        <span class="font-weight-bold font-size-22">SAR {{ $trip->price_per_bag }}</span>

                                                                    @endif

                                                                @else

                                                                    @if($trip->type == 1)

                                                                        <span class="font-weight-bold font-size-22">SAR {{ $trip->price_per_person }}</span>

                                                                    @else

                                                                        <span class="font-weight-bold font-size-22">SAR {{ $trip->price_per_bag }}</span>

                                                                    @endif

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

