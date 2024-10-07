@extends('layouts.front.master')
@section('title')
Cart List
@endsection
@section('front-additional-css')
<link rel="stylesheet" type="text/css" href="{{ asset('front/assets/css/product-summary.css') }}">
@endsection
@section('content')
@include('layouts.front.include.header1')
<main id="content">
<div class="container product_summary_section_container">
  <div class="row">
      <div class="col text-center">
          <div class="section_title new_arrivals_title">
              <h2>@lang('content.product_summary')</h2>
          </div>
      </div>
  </div>
  <div class="product-summary-box">
    <div class="delivery-option-box">
      <div class="delivery-option-title">
        <h3>@lang('content.product_delivery_option')</h3>
      </div>
      <hr>
      <div class="delivery-option-details">
          <p>{{ $current_user->name }}</p>
          @if(app()->getLocale() == 'ur')
            <p>{{ $single_address->flat_no }}, {{ $single_address->location }}, {{ $single_address->states->name_urdu }}, {{ $single_address->cities->name_urdu }}</p>
          @elseif(app()->getLocale() == 'ar')
            <p>{{ $single_address->flat_no }}, {{ $single_address->location }}, {{ $single_address->states->name_arabic }}, {{ $single_address->cities->name_arabic }}</p>
          @else
            <p>{{ $single_address->flat_no }}, {{ $single_address->location }}, {{ $single_address->states->name }}, {{ $single_address->cities->name }}</p>
          @endif
          
          <p>@lang('content.phone_no') : {{ $single_address->phone_no }}</p>
      </div>
    </div>
    <div class="shipment-box">
      <div class="shipment-title">
        <h3>@lang('content.shipment')</h3>
      </div>
      <hr>
      <div class="shipment-details">
        <div class="table-responsive checkout-right animated wow slideInUp" data-wow-delay=".5s">
          <table class="timetable_sub text-left">
            <tr>
              <th>@lang('content.name')</th>
              <th>@lang('content.price')</th>
              <th>@lang('content.qty')</th>
            </tr>
              @foreach ($carts as $show_cart)
                <tr class="rem1">
                  @if(app()->getLocale() == 'ur')
                    <td class="invert">{{ $show_cart['name_urdu'] }}</td>
                  @elseif(app()->getLocale() == 'ar')
                    <td class="invert">{{ $show_cart['name_arabic'] }}</td>
                  @else
                    <td class="invert">{{ $show_cart['name'] }}</td>
                  @endif
                  <td class="invert">{{ $show_cart['total_price'] }}</td>
                  <td class="invert">{{ $show_cart['quantity'] }}</td>
                </tr>
              @endforeach
          </table>
        </div>
      </div>
    </div>
  </div>

  <div class="payment-summary-box">
    <div class="payment-summary-title">
      <h3>@lang('content.product_summary')</h3>
    </div>
    <hr>
    <?php
      $cnt = 0;
      foreach ($carts as $cart) {
        $cnt = $cnt + $cart['total_price'];
      }
      $grand_total = $cnt;
    ?>
    <div class="payment-summary-content">
      <ul>
        <li>@lang('content.sub_total') <span>SR {{ $cnt }}</span></li>
        <li>@lang('content.total') <span>{{ $grand_total }}</span></li>
      </ul>
    </div>
  </div>
  <div class="add-new-address_btn text-center">
    <div class="button">
      <div class="continue-delivery justify-content-center">
        <div class="red_button shop_now_button">
          <a href="{{ URL::to('/payment-method/'.$single_address->id.'/'.$current_user->id) }}" class="btn btn-success btn-sm">@lang('content.continue_payment')</a>
        </div>
      </div>
    </div>
  </div>
</div>
</main>
@endsection
@section('front-additional-js')
<script type="text/javascript">
var user_id = {{ $current_user->id }}
window.localStorage.setItem('user_id', user_id);


var address_id = {{ $single_address->id }}
window.localStorage.setItem('address_id', address_id);
</script>
@endsection