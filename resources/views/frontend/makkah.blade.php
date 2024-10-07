@extends('layouts.front.master')
@section('title')
Mecca
@endsection
@section('front-additional-css')
<style type="text/css">
    .banner-img{
        height: 300px;
        width: 600px;
    }
</style>
@endsection
@section('content')
@include('layouts.front.include.header1')
<main id="content">
<!-- Breadcrumb -->
<div class="container">
    <nav class="py-3" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-no-gutter mb-0 flex-nowrap flex-xl-wrap overflow-auto overflow-xl-visble">
            <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1"><a href="#">@lang('content.top_city')</a></li>
            <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1 active" aria-current="page">@lang('content.mecca')</li>
        </ol>
    </nav>
</div>
<!-- End Breadcrumb -->


<div class="container">
    
    <div class="row">
        <div class="col-lg-12">
            <img class="mx-auto d-block banner-img" src="{{ asset('front/assets/images/makkah.jpg') }}" alt="Image">
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-lg-8 col-xl-9">
            <div class="d-block d-md-flex flex-center-between align-items-start">
                <div class="mb-1">
                    <div class="mb-2 mb-md-0">
                        <h4 class="font-size-23 font-weight-bold mb-1 mr-3">@lang('content.name'): @lang('content.mecca')</h4>
                    </div>
                </div>
            </div>
            <div class="border-bottom position-relative">
                <p class="mb-4">
                    <span class="font-weight-bold">@lang('content.description'):</span> @lang('content.mecca_content')
                </p>
                 
            </div>

        </div>
    </div>
   
</div>
</main>
@endsection
@section('front-additional-js')
@endsection