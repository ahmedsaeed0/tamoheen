@extends('layouts.front.master')
@section('title')
Terms
@endsection
@section('front-additional-css')
@endsection
@section('content')
@include('layouts.front.include.header1')
<main id="content">
<div class="container">
    
    <div class="row mt-4">
        <div class="col-lg-8 col-xl-9 offset-lg-2">
            <h2 class="text-center">Terms</h2>
            <p class="mb-4">
                {{ $term->description }}.
            </p>
        </div>
    </div>
   
</div>
</main>
@endsection
@section('front-additional-js')
@endsection