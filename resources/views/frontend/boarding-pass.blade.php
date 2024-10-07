@extends('layouts.front.master')
@section('title')
Trip Boarding Pass
@endsection
@section('front-additional-css')
<link rel="stylesheet" href="{{ asset('mobile/css/boarding.css') }}">
@endsection
@section('content')
@include('layouts.front.include.header1')
<section class="section_padding border border-5">
    <div class="container">
    <div class="row">
        <div class="col-12 p-0">
            @foreach($tripbooking->passengers as $passenger)
            <div class="default-bg-blue text-white p-3 mt-3 boarding">
                <p>Boarding Pass {{ $loop->iteration }}</p>
                <p>Full Name: {{ $passenger->name }}</p>
                <p>ID Number: {{ $passenger->trip_booking_id }}</p>
                <p>Driver name: {{ $passenger->trip->user->name }}</p>
                <p>Car Number: {{ $passenger->trip->cars->id }}</p>
            </div>
            @endforeach
        </div>

        <div class="col-6 default-bg-ash en-item pt-3 pl-3">
            <div class="text-start">
                <h4 class="pl-2">{{ $tripbooking->trip->cityFrom->name }}</h4>
                <h4 class="pl-2">{{ Carbon\Carbon::parse($tripbooking->trip->date)->format('d/m/Y') }}</h4>
            </div>
        </div>
        <div class="col-6 text-end default-bg-ash en-item2 pt-3 pr-3">
            <div class="text-right">
                <h4 class="pr-2">{{ $tripbooking->trip->cityTo->name }}</h4>
                <h4 class="pr-2">{{ Carbon\Carbon::parse($tripbooking->trip->date)->format('h:i A') }}</h4>
            </div>
        </div>

        <div class="col-12 pt-5">
            <img class="d-block mx-auto" src="{{asset($image)}}" alt="">
        </div>
    </div>
    </div>
</section>
@endsection
@section('front-additional-js')
@endsection