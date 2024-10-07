@extends('layouts.front.master')
@section('title')
Order List
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
                <h2>@lang('content.order_list')</h2>
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
                            <th>#</th>
                            <th>@lang('content.price')</th>
                            <th>@lang('content.payment_method')</th>
                            <th>@lang('content.estimate_time')</th>
                            <th>@lang('content.status')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $item)
                            <tr>
                                <td class="invert">{{ $loop->iteration }}</td>
                                <td class="invert">{{ $item->final_price }}</td>
                                <td class="invert">{{ $item->payment_method }}</td>
                                <td class="invert">{{ $item->estimated_time }}</td>
                                <td class="invert">
                                    @if($item->order_status == 1)
                                        <span class="badge badge-success">@lang('content.pending')</span>
                                    @elseif($item->order_status == 2)
                                        <span class="badge badge-success">@lang('content.accepted')</span>
                                    @elseif($item->order_status == 3)
                                        <span class="badge badge-success">@lang('content.on_going')</span>
                                    @else
                                        <span class="badge badge-success">@lang('content.delivered')</span>
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