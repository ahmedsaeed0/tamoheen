@extends('layouts.front.master')
@section('title')
Ship Booking List
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
                <h2>@lang('header.ship_booking_list')</h2>
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
            <div class="table-responsive checkout-right animated wow slideInUp" data-wow-delay=".5s">
                <table class="timetable_sub">
                    <thead>
                        <tr>
                            <th>@lang('booking-list.trip')</th>
                            <th>@lang('booking-list.number_of_bag')</th>
                            <th>@lang('booking-list.price')</th>
                            <th>@lang('booking-list.paymentstatus')</th>
                            <th>@lang('booking-list.bookingstatus')</th>
                            <th>@lang('booking-list.actions')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tripbookings as $booking)

                            <tr>
                                @if(app()->getLocale() == 'ur')
                                    <td class="invert">{{ $booking->trip->title_urdu }}</td>
                                @elseif(app()->getLocale() == 'ar')
                                    <td class="invert">{{ $booking->trip->title_arabic }}</td>
                                @else
                                    <td class="invert">{{ $booking->trip->title }}</td>
                                @endif
                                <td class="invert">{{ $booking->number_of_bag }}</td>
                                <td class="invert">{{ $booking->price }}</td>
                                <td class="invert">
                                    @if($booking->is_payment_complete == 1)
                                        <span class="badge badge-success">@lang('booking-list.complete')</span>
                                    @else
                                        <span class="badge badge-danger">@lang('booking-list.incomplete')</span>
                                    @endif
                                </td>
                                <td class="invert">
                                    @if($booking->status == 1)
                                        <span class="badge badge-success">@lang('booking-list.success')</span>
                                    @elseif($booking->status == 2)
                                        <span class="badge badge-primary">@lang('booking-list.checked_in')</span>
                                    @elseif($booking->status == 3)
                                        <span class="badge badge-info">@lang('booking-list.checked_out')</span>
                                    @elseif($booking->status == 0)
                                        <span class="badge badge-info">Cancel</span>
                                    @else
                                        <span class="badge badge-success">@lang('booking-list.completed')</span>
                                    @endif
                                </td>
                                <td class="invert">
                                    @if(count($booking->reviews) == 0)
                                    <a href="{{ url('ship-review/'.$booking->id) }}" class="btn btn-sm btn-success">
                                        @lang('booking-list.review')
                                    </a>
                                    @endif

                                    @if(count($booking->trip->complains) == 0)
                                    <a href="{{ url('complain/'.$booking->id.'/ship') }}" class="btn btn-sm btn-success">
                                        @lang('booking-list.complain')
                                    </a>
                                    @endif

                                    @if(($booking->status != 0) &&($booking->status != 2) && ($booking->status != 3) && ($booking->status != 3) && ($booking->status != 4))
                                        <a href="{{ url('ship-booking-cancel/'.$booking->id) }}" class="btn btn-sm btn-success">
                                            Trip Cancel
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    
                </table>
            </div>
        </div>
</main>
@endsection
@section('front-additional-js')
@endsection