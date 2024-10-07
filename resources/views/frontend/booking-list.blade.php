@extends('layouts.front.master')

@section('title')

Booking List

@endsection

@section('front-additional-css')

<link rel="stylesheet" type="text/css" href="{{ asset('front/assets/css/cart.css') }}">

@endsection

@section('content')

@include('layouts.front.include.header1')

<main id="content">

	<div class="container cart_section_container">

    <div class="row">

        <div class="col text-center">

            <div class="section_title new_arrivals_title">

                <h2>@lang('booking-list.booking_list')</h2>

                @if(session()->has('success'))

                    <span class="text-success text-center">{{ Session::get('success') }}</span>

                @endif

                @if(session()->has('error'))

                    <span class="text-danger text-center">{{ Session::get('error') }}</span>

                @endif

            </div>

        </div>

    </div>

    <div class="checkout checkout-margin-top">

        <div class="container">


            @foreach ($tripbookings as $booking)
                
                <div class="card">

                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-6">

                                <p>

                                    @lang('booking-list.trip') : 

                                        @if(app()->getLocale() == 'ur')

                                             {{ App\Http\Controllers\FrontendsController::getBrandName($booking->trip->user_id) }}-{{$booking->trip_id}}

                                        @elseif(app()->getLocale() == 'ar')

                                             {{ App\Http\Controllers\FrontendsController::getBrandName($booking->trip->user_id) }}-{{$booking->trip_id}}

                                        @else

                                            {{ App\Http\Controllers\FrontendsController::getBrandName($booking->trip->user_id) }}-{{$booking->trip_id}}

                                        @endif

                                </p>

                                

                                 <p>

                                    @lang('home.what_state_from') : 

                                        @if(app()->getLocale() == 'ur')

                                             {{ $booking->trip->cityFrom->name_urdu }}

                                        @elseif(app()->getLocale() == 'ar')

                                            {{ $booking->trip->cityFrom->name_arabic }}

                                        @else

                                            {{ $booking->trip->cityFrom->name }}

                                        @endif

                                   </p>

                                <p>

                                    @lang('home.destination') : 

                                        @if(app()->getLocale() == 'ur')

                                             {{ $booking->trip->cityTo->name_urdu }}

                                        @elseif(app()->getLocale() == 'ar')

                                            {{ $booking->trip->cityTo->name_arabic }}

                                        @else

                                            {{ $booking->trip->cityTo->name }}

                                        @endif

                                   </p>

                                <p>@lang('booking-list.number_of_person') : {{ $booking->number_of_passengers }}</p>

                                <?php $passengers = $booking->passengers; ?>
                                <p>@lang('booking-list.person_name') :
                                    <br>
                                    <?php
                                    foreach ($passengers as $key => $passenger) { ?>
                                        &nbsp;&nbsp;&nbsp;{{ ($key + 1) }}. {{ $passenger->name }}<br>
                                    <?php  } ?>
                                </p>
                            </div>

                            <div class="col-md-6">

                                <p>

                                    @lang('booking-list.paymentstatus') :

                                        @if($booking->is_payment_complete == 1)

                                            <span class="badge badge-success">@lang('booking-list.complete')</span>

                                        @else

                                            <span class="badge badge-danger">@lang('booking-list.incomplete')</span>

                                        @endif

                                </p>

                                <p>@lang('booking-list.trip_date') : {{ $booking->trip->date }}</p>

                                <p>@lang('booking-list.price') : {{ $booking->price }}</p>

                                <p>

                                    @lang('booking-list.bookingstatus') : 

                                        @if($booking->status == 1 && $booking->is_payment_complete == 1)

                                            <span class="badge badge-success">@lang('booking-list.success')</span>

                                        @elseif($booking->status == 1 && $booking->is_payment_complete == 0)

                                            <span class="badge badge-success">@lang('booking-list.pending')</span>

                                        @elseif($booking->status == 2)

                                            <span class="badge badge-primary">@lang('booking-list.checked_in')</span>

                                        @elseif($booking->status == 3)

                                            <span class="badge badge-info">@lang('booking-list.checked_out')</span>

                                        @elseif($booking->status == 0)

                                            @if($booking->cancel_date != '')

                                            <br>

                                            <small>@lang('booking-list.cancelled_by') : {{$booking->cancelled_by }}</small>

                                            <br>

                                            <small>@lang('booking-list.cancelled_on') : {{$booking->cancel_date}}</small>

                                            <br>

                                            <!-- {{$booking->id}} {{$booking->user_id}} -->

                                            @else

                                                @if($booking->trip->status == 3)

                                                    <span class="badge badge-info">{{"Completed"}}</span>

                                                @else   

                                                    <span class="badge badge-info">{{'Pending'}}</span>

                                                @endif

                                            @endif

                                        @else

                                            <span class="badge badge-success">@lang('booking-list.completed')</span>

                                        @endif





                                        

                                </p>

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-12">

                                  {{--@if(!isset($booking->reviews) && $booking->reviews == null)--}}

                                    <a href="{{ url('review/'.$booking->id) }}" class="btn btn-sm btn-success">

                                        {{-- @lang('booking-list.review') --}}

                                        @lang('booking-list.review')

                                    </a>

                                    {{--@endif--}}



                                    {{--@if(count($booking->trip->complains) == 0)--}}

                                        <a href="{{ url('complain/'.$booking->id.'/trip') }}" class="btn btn-sm btn-primary">

                                             @lang('booking-list.complain')

                                        </a>

                                    {{--@endif--}}





                                    @if($booking->cancel_date == "")

                                     @if($booking->trip->status != 3)

                                        @if(app()->getLocale() == 'ar')

                                            <a href="{{ url('ar/trip-booking-cancel/'.$booking->id) }}" class="btn btn-sm btn-info">

                                                Cancel 

                                            </a>

                                        @elseif(app()->getLocale() == 'en')

                                            <a href="{{ url('en/trip-booking-cancel/'.$booking->id) }}" class="btn btn-sm btn-info">

                                                Cancel

                                            </a>

                                        @endif

                                      @endif

                                    @endif

                                    





                                    {{--me cancel link --}}

                                    @if(($booking->status != 0 && $booking->status != 2 && $booking->status != 3 && $booking->status != 3 && $booking->status != 4))

                                        <a href="{{ url('trip-booking-cancel/'.$booking->id) }}" class="btn btn-sm btn-danger d-none">

                                            <i class="fas fa-ban"> cancel trip</i>

                                        </a>

                                    @endif 

                                    @if($booking->status == 1)

                                        <a href="{{ url('trip-booking-cancel/'.$booking->id) }}" class="btn btn-sm btn-danger d-none">

                                            <i class="fas fa-ban"></i>

                                        </a>

                                    @endif

                            </div>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

</main>

@endsection

@section('front-additional-js')

@endsection

