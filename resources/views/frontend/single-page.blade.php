@extends('layouts.front.master')
@section('title')

{{ $page->title  }}
@endsection
@section('front-additional-css')
@endsection
@section('content')
@include('layouts.front.include.header1')
<main id="content">
<div class="container">

    <div class="row mt-4 justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    @if(app()->getLocale() == 'ar')
                        <h2 class="text-center mb-4" style="font-family: 'Cairo', sans-serif;">{{ $page->title_arabic }}</h2>
                    @else
                        <h2 class="text-center mb-4" style="font-family: 'Roboto', sans-serif;">{{ $page->title }}</h2>
                    @endif
    
                    <hr class="my-4">
    
                    <div class="content">
                        @if(app()->getLocale() == 'ar')
                            <div class="text-right" style="font-family: 'Cairo', sans-serif; line-height: 1.8;">
                                {!! $page->content_arabic !!}
                            </div>
                        @else
                            <div class="text-left" style="font-family: 'Roboto', sans-serif; line-height: 1.8;">
                                {!! $page->content !!}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    

</div>
</main>
@endsection
@section('front-additional-js')
@endsection
