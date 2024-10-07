@extends('layouts.front.master')

@section('title')
Mecca
@endsection

@section('front-additional-css')
<style type="text/css">
    .banner-img {
        height: auto;
        width: 100%;
        max-width: 1200px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .breadcrumb {
        background-color: #f8f9fa;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .breadcrumb-item a {
        font-size: 16px;
        color: #007bff;
        transition: color 0.3s ease;
    }

    .breadcrumb-item a:hover {
        color: #0056b3;
        text-decoration: underline;
    }

    h4 {
        font-family: 'Cairo', sans-serif;
        font-weight: 700;
        font-size: 24px;
        color: #343a40;
    }

    p {
        font-family: 'Cairo', sans-serif;
        font-size: 16px;
        line-height: 1.8;
        color: #555;
    }

    .border-bottom {
        padding-bottom: 1rem;
        margin-bottom: 1rem;
        border-bottom: 1px solid #e9ecef;
    }

    /* تأثير جميل عند تمرير الماوس على العناصر */
    .banner-img:hover {
        transform: scale(1.02);
        transition: transform 0.3s ease;
    }

</style>
@endsection

@section('content')

@include('layouts.front.include.header1')

<main id="content">

<!-- Breadcrumb -->
<div class="container">
    <nav class="py-3" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-no-gutter mb-0 flex-nowrap flex-xl-wrap overflow-auto overflow-xl-visible">
            <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1">
                <a href="#" class="text-decoration-none">
                    <i class="fas fa-map-marker-alt"></i> @lang('content.top_city')
                </a>
            </li>

            <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1 active" aria-current="page">
                @if (app()->getLocale() == 'ar')
                    {{ $city->name_arabic }}
                @else
                    {{ $city->name }}
                @endif
            </li>
        </ol>
    </nav>
</div>
<!-- End Breadcrumb -->

<div class="container">
    <div class="row">
        <div class="col-lg-12 text-center">
            <img class="mx-auto banner-img" src="{{ $images[0]->url }}" alt="Image">
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-8 col-xl-9">
            <div class="d-block d-md-flex flex-center-between align-items-start">
                <div class="mb-1">
                    <h4 class="font-weight-bold mb-1 mr-3">@lang('content.name'):
                        @if (app()->getLocale() == 'ar')
                            {{ $city->name_arabic }}
                        @else
                            {{ $city->name }}
                        @endif
                    </h4>
                </div>
            </div>

            <div class="border-bottom position-relative">
                <p class="mb-4">
                    <span class="font-weight-bold">@lang('content.description'):</span>
                    @if (app()->getLocale() == 'ar')
                        {!! $city->description_arabic !!}
                    @else
                        {!! $city->description !!}
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>

</main>
@endsection

@section('front-additional-js')
@endsection
