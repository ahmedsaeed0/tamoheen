@extends('layouts.front.master')

@section('title')

Single Trip Name

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

            <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1"><a href="#">@lang('content.home')</a></li>

        </ol>

    </nav>

</div>

<!-- End Breadcrumb -->

<div class="gallery-slider">



    <!-- __images -->

    <div class="gallery-slider__images">

      <div>

        @foreach($trip->cars->images as $key => $img)

            <div class="item">

                <div class="img-fill"><img src="{{ $img->url }}" alt=""></div>

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

        @foreach($trip->cars->images as $key => $img)

        <div class="item">

          <div class="img-fill"><img src="{{ $img->url }}" alt=""></div>

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



<div class="container">

    <div class="row">

        <div class="col-lg-8 col-xl-9">

            <div class="d-block d-md-flex flex-center-between align-items-start mb-3">

                <div class="mb-1">

                    <div class="mb-2 mb-md-0">



                        @if(app()->getLocale() == 'ar')

                            <h4 class="font-size-23 font-weight-bold mb-1 text-right">{{ $trip->title_arabic }}</h4>

                            <p class="text-right">{{$car->name_arabic}}</p>

                        @else

                        
                            <h4 class="font-size-23 font-weight-bold mb-1">{{ App\Http\Controllers\FrontendsController::getBrandName($trip->user_id) ?? ''}}-{{$trip->id ?? ''}}</h4>

                            <p>{{$car->name}}</p>

                        @endif



                        



                    </div>

                    <div class="d-block d-xl-flex flex-horizontal-center">

                        <div class="d-block d-md-flex flex-horizontal-center font-size-14 text-gray-1 mb-2 mb-xl-0">

                            <i class="icon flaticon-placeholder mr-2 font-size-20"></i> {{ $trip->start_point }}

                            <a href="#" class="mx-1 d-block d-md-inline"> - @lang('content.view_on_map')</a>

                        </div>

                        {{-- <div class="mr-4 mb-2 mb-md-0 flex-horizontal-center">

                            <div class="mx-xl-3 font-size-10 letter-spacing-2">

                                <span class="d-block green-lighter mx-1">

                                    <span class="fas fa-star"></span>

                                    <span class="fas fa-star"></span>

                                    <span class="fas fa-star"></span>

                                    <span class="fas fa-star"></span>

                                    <span class="fas fa-star"></span>

                                </span>

                            </div>

                            <span class="font-size-14 text-gray-1 mx-2">(1,186 Reviews)</span>

                        </div> --}}

                    </div>

                </div>

                {{-- <ul class="list-group list-group-borderless list-group-horizontal custom-social-share">

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

                </ul> --}}

            </div>

            <div class="py-4 border-top border-bottom mb-4">

                <ul class="list-group list-group-borderless list-group-horizontal row">

                    <li class="col-md-4 flex-horizontal-center list-group-item text-lh-sm mb-2">

                        <i class="flaticon-alarm text-primary font-size-22 mr-2 d-block"></i>

                        <div class="mx-1 text-gray-1">@lang('content.date'): {{ Carbon\Carbon::parse($trip->date)->format('d-m-Y h:i') }}</div>

                    </li>

                    <li class="col-md-4 flex-horizontal-center list-group-item text-lh-sm mb-2">

                        <i class="flaticon-social text-primary font-size-22 mr-2 d-block"></i>

                        @if($trip->type == 1)

                            <div class="mx-1 text-gray-1">@lang('content.max_people') : {{ $trip->available_of_person }}</div>

                        @else

                            <div class="mx-1 text-gray-1">Max Bag : {{ $trip->available_of_bag }}</div>

                        @endif

                    </li>

                    @if(app()->getLocale() == 'ur')

                        @foreach($trip->cars->carFeatures as $feature)



                        <li class="col-md-4 flex-horizontal-center list-group-item text-lh-sm mb-2">

                            {{-- <i class="flaticon-wifi-signal text-primary font-size-22 mr-2 d-block"></i> --}}

                            @if($feature->image != null)

                                <img src="{{ $feature->image->url }}" alt="{{ $feature->name_urdu }}" id="userImg" style="width: 20px; height: 20px;" />

                            @else

                                <span class="badge badge-danger">No Image Found!</span>

                            @endif

                            <div class="mx-1 text-gray-1">{{ $feature->name_urdu }} @lang('content.available')</div>

                        </li>

                        @endforeach

                    @elseif(app()->getLocale() == 'ar')

                        @foreach($trip->cars->carFeatures as $feature)



                        <li class="col-md-4 flex-horizontal-center list-group-item text-lh-sm mb-2">

                            {{-- <i class="flaticon-wifi-signal text-primary font-size-22 mr-2 d-block"></i> --}}

                            @if($feature->image != null)

                                <img src="{{ $feature->image->url }}" alt="{{ $feature->name_arabic }}" id="userImg" style="width: 20px; height: 20px;"/>

                            @else

                                <span class="badge badge-danger">No Image Found!</span>

                            @endif

                            <div class="mx-1 text-gray-1">{{ $feature->name_arabic }} @lang('content.available')</div>

                        </li>

                        @endforeach

                    @else

                        @foreach($trip->cars->carFeatures as $feature)



                        <li class="col-md-4 flex-horizontal-center list-group-item text-lh-sm mb-2">

                            {{-- <i class="flaticon-wifi-signal text-primary font-size-22 mr-2 d-block"></i> --}}

                            @if($feature->image != null)

                                <img src="{{ $feature->image->url }}" alt="{{ $feature->name }}" id="userImg" style="width: 20px; height: 20px;"/>

                            @else

                                <span class="badge badge-danger">No Image Found!</span>

                            @endif

                            <div class="mx-1 text-gray-1">{{ $feature->name }} @lang('content.available')</div>

                        </li>

                        @endforeach

                    @endif



                    <li class="col-md-4 flex-horizontal-center list-group-item text-lh-sm mb-2">

                        <i class="flaticon-pin text-primary font-size-22 mr-2 d-block"></i>

                        <div class="mx-1 text-gray-1">@lang('content.pickup'): {{ $trip->start_point }}</div>

                    </li>

                    <li class="col-md-4 flex-horizontal-center list-group-item text-lh-sm mb-2">

                        <i class="flaticon-social text-primary font-size-22 mr-2 d-block"></i>
                            @if($trip->available_of_person != 0 && $trip->available_of_person >= 0)
                                <div class="mx-1 text-gray-1">@lang('content.available_person'): <span class='text-danger'>{{ $trip->available_of_person }}</span></div>
                            @else
                            <div class="mx-1 text-gray-1">@lang('content.available_person'): <span class='text-danger'>@lang('content.no_available_person')</span></div>
                            @endif
                    </li>

                </ul>

            </div>

            <div class="border-bottom position-relative @if(app()->getLocale() == 'ar') text-right @endif">

                <h5 class="font-size-21 font-weight-bold text-dark mb-3">

                    @lang('content.description')

                </h5>

                @if(app()->getLocale() == 'ur')

                    <p class="mb-4">{{ $trip->description_urdu }}</p>

                @elseif(app()->getLocale() == 'ar')

                    <p class="mb-4">{{ $trip->description_arabic }}</p>

                @else

                    <p class="mb-4">{{ $trip->description }}</p>

                @endif



            </div>

            <?php

                $sql = "SELECT * FROM reviews r LEFT JOIN trips t ON t.id = r.trip_id WHERE t.user_id =   ".$trip->user_id;

                $results = DB::select($sql);

                Lang::locale();

                if(!empty($results)){

            ?>

            <div class="border-bottom position-relative @if(app()->getLocale() == 'ar') text-right @endif">

                <h5 class="font-size-21 font-weight-bold text-dark mb-3">

                    @lang('content.reviews')

                </h5>  

                <?php

                   

                    foreach($results as $r){

                ?>

                    <div class="row" style="margin-bottom:20px">

                        <div class="col-md-9">

                            <?php

                               

                                echo $r->review;

                            ?>

                        </div>

                        <div class="col-md-3">

                            <?php

                                for($i = 1; $i<= $r->rating; $i++){

                                    echo "<i class='fa fa-star'></i>";

                                }

                            ?>

                        </div>

                    </div>

                    <hr>

                <?php

                    }

                ?>                          

            </div>

            <?php

                }

            ?>

        </div>

        <div class="col-lg-4 col-xl-3">

            <!--@if($trip->type == 1)

                @if(app()->getLocale() == 'ur')

                    <form action="{{ url('ur/trip-booking-form') }}" method="POST">

                @elseif(app()->getLocale() == 'ar')

                    <form action="{{ url('ar/trip-booking-form') }}" method="POST">

                @else

                    <form action="{{ url('trip-booking-form') }}" method="POST">

                @endif

            @else

                @if(app()->getLocale() == 'ur')

                    <form action="{{ url('ur/shipment-form') }}" method="POST">

                @elseif(app()->getLocale() == 'ar')

                    <form action="{{ url('ar/shipment-form') }}" method="POST">

                @else

                    <form action="{{ url('shipment-form') }}" method="POST">

                @endif



            @endif

            @csrf-->

            <div class="mb-4">

                <div class="border border-color-7 rounded mb-5">

                    <div class="border-bottom">

                        <div class="p-4">

                            <span class="font-size-14">@lang('content.price')</span>

                            {{-- @if($trip->type == 1)

                                <span class="font-size-24 text-gray-6 font-weight-bold mx-1">${{ $trip->price_per_person }}.00</span>

                            @else

                                 <span class="font-size-24 text-gray-6 font-weight-bold mx-1">${{ $trip->price_per_bag }}.00</span>

                            @endif --}}



                            @if($trip->discount > 0)

                                <i class="fas fa-fire text-danger font-size-22 mr-1"></i>

                                {{-- <span class="mr-1 font-size-14 text-gray-1">@lang('content.from')</span> --}}

                                @if($trip->type == 1)

                                <span class="font-size-24 text-gray-6 font-weight-bold mx-1">SAR {{ $trip->discount }}</span>

                                <span class="font-size-16 text-gray-6 font-weight-bold mx-1"><s>SAR {{ $trip->price_per_person }}</s></span>

                                @else

                                    <span class="font-size-24 text-gray-6 font-weight-bold mx-1">SAR {{ $trip->price_per_bag }}</span>

                                @endif

                            @else

                                @if($trip->type == 1)

                                    <span class="font-size-24 text-gray-6 font-weight-bold mx-1">SAR {{ $trip->price_per_person }}</span>

                                @else

                                    <span class="font-size-24 text-gray-6 font-weight-bold mx-1">SAR {{ $trip->price_per_bag }}</span>

                                @endif

                            @endif



                        </div>

                    </div>

                    <input type="hidden" name="trip_id" value="{{ $trip->id }}">

                    <div class="p-4">

                        <!-- Input -->

                        @if(app()->getLocale() == 'en')

                        <span class="d-block text-gray-1 font-weight-normal mb-0 text-left">@lang('content.date')</span>

                        @else

                        <span class="d-block text-gray-1 font-weight-normal mb-0 text-right">@lang('content.date')</span>

                        @endif

                        <div class="mb-4">

                            <div class="border-bottom border-width-2 border-color-1">

                                <div id="datepickerWrapperPick" class="u-datepicker input-group">

                                    <p>{{ Carbon\Carbon::parse($trip->date)->format('M d Y') }}</p>

                                    <input name="date" value="{{ Carbon\Carbon::parse($trip->date)->format('M d Y') }}" type="hidden">

                                </div>

                                <!-- End Datepicker -->

                            </div>

                        </div>

                        <!-- End Input -->

                        @if($trip->type == 1)

                        <!-- Input -->

                        

                        @if(app()->getLocale() == 'en')

                        <span class="d-block text-gray-1 font-weight-normal mb-2 text-left">@lang('content.number_of_person')</span>

                        @else

                        <span class="d-block text-gray-1 font-weight-normal mb-2 text-right">@lang('content.number_of_person')</span>

                        @endif    

                        

                        

                        <div class="mb-4">

                            <div class="border-bottom border-width-2 border-color-1 pb-1">

                                <div class="js-quantity flex-center-between mb-1 text-dark font-weight-bold">

                                    {{-- <span class="d-block">Number Of Person</span> --}}

                                    <div class="flex-horizontal-center">

                                        <!--<a class="js-minus font-size-10 text-dark" href="javascript:;">

                                            <i class="fas fa-chevron-up"></i>

                                        </a>-->

                                        <input class="js-result form-control h-auto width-30 font-weight-bold font-size-16 shadow-none bg-tranparent border-0 rounded p-0 mx-1 text-center" type="text" value="{{ Session::get('number_of_person') }}" min="01" max="{{ $trip->available_of_person }}" name="number_of_person" readonly />

                                        <!--<a class="js-plus font-size-10 text-dark" href="javascript:;">

                                            <i class="fas fa-chevron-down"></i>

                                        </a>-->

                                    </div>

                                </div>

                            </div>

                        </div>

                        <!-- End Input -->

                        @endif

                        <div class="text-center">

                            @if(session()->has('warning'))

                                <span class="text-warning">{{ Session::get('warning') }}</span>

                            @endif

                            @php

                                $number_of_person = Session::get('number_of_person');

                                $trip_id = $trip->id;

                            @endphp

                            <a href="{{ url('trip-booking-form?number_of_person='.$number_of_person.'&trip_id='.$trip_id) }}">

                                <button type="button" class="btn btn-primary d-flex align-items-center justify-content-center  height-60 w-100 mb-xl-0 mb-lg-1 transition-3d-hover font-weight-bold">@lang('content.book_now')</button>

                            </a>

                            <!--<button type="submit" class="btn btn-primary d-flex align-items-center justify-content-center  height-60 w-100 mb-xl-0 mb-lg-1 transition-3d-hover font-weight-bold">@lang('content.book_now')</button>-->

                        </div>

                    </div>

                    </form>

                </div>

                <div class="border border-color-7 rounded p-4 mb-5">

                    <h6 class="font-size-17 font-weight-bold text-gray-3 mx-2 mb-3 pb-1 @if(app()->getLocale() == 'ar') text-right @endif">@lang('content.why_book')?</h6>

                    <div class="d-flex align-items-center mb-3">

                        <i class="flaticon-star font-size-25 text-primary mx-2 pr-1"></i>

                        <h6 class="mb-0 font-size-14 text-gray-1">

                            <a href="#">@lang('content.no_hassle')</a>

                        </h6>

                    </div>

                    <div class="d-flex align-items-center mb-3">

                        <i class="flaticon-support font-size-25 text-primary mx-2 pr-1"></i>

                        <h6 class="mb-0 font-size-14 text-gray-1">

                            <a href="#">@lang('content.customer_care')</a>

                        </h6>

                    </div>

                    <div class="d-flex align-items-center mb-3">

                        <i class="flaticon-favorites-button font-size-25 text-primary mx-2 pr-1"></i>

                        <h6 class="mb-0 font-size-14 text-gray-1">

                            <a href="#">@lang('content.hand_picked')s &amp; @lang('content.activities')</a>

                        </h6>

                    </div>

                    <!-- <div class="d-flex align-items-center mb-0">

                        <i class="fas fa-bus font-size-25 text-primary mx-2 pr-1"></i>

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

