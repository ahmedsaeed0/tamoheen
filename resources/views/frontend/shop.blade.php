@extends('layouts.front.master')

@section('title')

Product List

@endsection

@section('front-additional-css')

@endsection

@section('content')

@include('layouts.front.include.header1')

<main id="content" role="main">

    <div class="container space-1">

        <div class="w-md-80 w-lg-50 text-center mx-md-auto my-3">

            <h2 class="section-title text-black font-size-30 font-weight-bold mb-0">@lang('home.shop')</h2>

        </div>

        <!-- Nav Classic -->

        <ul class="nav tab-nav-pill flex-nowrap pb-4 pb-lg-5 tab-nav justify-content-lg-center" role="tablist">

            @if(app()->getLocale() == 'ur')

                @foreach($categories as $value)

                <li class="nav-item">

                    <a class="nav-link font-weight-medium {{ ($loop->iteration == 1) ? 'active' : '' }}"  id="pills-one-example-t1-tab" data-toggle="tab" onclick="openTab({{ $value->id }})" role="tab" >

                        <div class="d-flex flex-column flex-md-row  position-relative text-dark align-items-center">

                            <span class="tabtext font-weight-semi-bold">{{  $value->name_urdu }}</span>

                        </div>

                    </a>

                </li>

                @endforeach

            @elseif(app()->getLocale() == 'ar')

                @foreach($categories as $value)

                <li class="nav-item">

                    <a class="nav-link font-weight-medium {{ ($loop->iteration == 1) ? 'active' : '' }}"  id="pills-one-example-t1-tab" data-toggle="tab" onclick="openTab({{ $value->id }})" role="tab" >

                        <div class="d-flex flex-column flex-md-row  position-relative text-dark align-items-center">

                            <span class="tabtext font-weight-semi-bold">{{  $value->name_arabic }}</span>

                        </div>

                    </a>

                </li>

                @endforeach

            @else

                @foreach($categories as $value)

                <li class="nav-item">

                    <a class="nav-link font-weight-medium {{ ($loop->iteration == 1) ? 'active' : '' }}"  id="pills-one-example-t1-tab" data-toggle="tab" onclick="openTab({{ $value->id }})" role="tab" >

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

            <div class="tab-pane fade show {{ ($loop->iteration == 1) ? 'active' : '' }}"  id="tab{{ $value1->id }}" role="tabpanel" aria-labelledby="pills-one-example-t1-tab">

                <div class="row">

                    @if(app()->getLocale() == 'ur')

                    @foreach($products as $item)

                    @if($value1->id == $item->category_id)

                        <div class="col-md-6 col-lg-4 col-xl-3 mb-3 mb-md-4 pb-1">

                        <div class="card mb-1 transition-3d-hover shadow-hover-2 tab-card h-100">

                            <div class="position-relative mb-2">

                                <a href="{{ url('single-product/'.$item->id) }}" class="d-block gradient-overlay-half-bg-gradient-v5">

                                    <img class="card-img-top" src="{{ $item->image->url }}" alt="img">

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

                                            <img class="card-img-top" src="{{ $item->image->url }}" alt="img">

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

                                            <img class="card-img-top" src="{{ $item->image->url }}" alt="img">

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

</main>

@endsection

@section('front-additional-js')

<script type="text/javascript">

    function openTab(id){

        $('.tab-pane').hide();

        $('#tab'+id).show();

    }

</script>

@endsection