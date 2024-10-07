@extends('layouts.front.master')
@section('title')
Address List
@endsection
@section('front-additional-css')
<link rel="stylesheet" type="text/css" href="{{ asset('front/assets/css/address.css') }}">
@endsection
@section('content')
@include('layouts.front.include.header1')
<main id="content">
<div class="container address_section_container">
    <div class="row">
        <div class="col text-center">
            <div class="section_title new_arrivals_title">
                <h2>@lang('address.address')</h2>
                @if(session()->has('success'))
                  <span class="text-success text-center">{{ Session::get('success') }}</span>
                @endif
            </div>
        </div>
    </div>
    <div class="address">
      @if(app()->getLocale() == 'ur')
        @foreach ($address as $show_address)
            <a href="{{ url('/product-summary/'.$show_address['id']) }}">
              	<div class="address-box effect">
	                <div class="aaaa">

		                <p>{{ $show_address['flat_no'] }},{{ $show_address['location'] }}, {{ $show_address['state']['name_urdu'] }}, {{ $show_address['city']['name_urdu'] }}, {{ $show_address['country']['name_urdu'] }},</p>
		                <p>{{ $show_address['phone_no'] }},</p>
	              	</div>
              	<a class="delete-icon" href="{{ URL::to('/delete-address/'.$show_address['id']) }}" >
              		<i class="fa fa-trash"></i>
              	</a>

              	</div>
            </a>
        @endforeach
      @elseif(app()->getLocale() == 'ar')
        @foreach ($address as $show_address)
            <a href="{{ url('/product-summary/'.$show_address['id']) }}">
                <div class="address-box effect">
                  <div class="aaaa">

                    <p>{{ $show_address['flat_no'] }},{{ $show_address['location'] }}, {{ $show_address['state']['name_arabic'] }}, {{ $show_address['city']['name_arabic'] }}, {{ $show_address['country']['name_arabic'] }},</p>
                    <p>{{ $show_address['phone_no'] }},</p>
                  </div>
                <a class="delete-icon" href="{{ URL::to('/delete-address/'.$show_address['id']) }}" >
                  <i class="fa fa-trash"></i>
                </a>

                </div>
            </a>
        @endforeach
      @else
        @foreach ($address as $show_address)
            <a href="{{ url('/product-summary/'.$show_address['id']) }}">
                <div class="address-box effect">
                  <div class="aaaa">

                    <p>{{ $show_address['flat_no'] }},{{ $show_address['location'] }}, {{ $show_address['state']['name'] }}, {{ $show_address['city']['name'] }}, {{ $show_address['country']['name'] }},</p>
                    <p>{{ $show_address['phone_no'] }},</p>
                  </div>
                <a class="delete-icon" href="{{ URL::to('/delete-address/'.$show_address['id']) }}" >
                  <i class="fa fa-trash"></i>
                </a>

                </div>
            </a>
        @endforeach
      @endif
    </div>
      <div class="add-new-address_btn text-center">
        <div class="button">
          <div class="continue-delivery justify-content-center">
            <div class="red_button shop_now_button">
            	<a href="{{ URL::to('/add-address') }}" class="btn btn-success btn-sm">@lang('address.add_address')</a>
            </div>
          </div>
        </div>
      </div>
  </div>
</main>
@endsection
@section('front-additional-js')
@endsection