@extends('layouts.front.master')
@section('title')
Cart List
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
                <h2>@lang('cart.cart')</h2>
            </div>
        </div>
    </div>
    <div class="checkout checkout-margin-top">
        <div class="container">
            <div class="table-responsive checkout-right animated wow slideInUp" data-wow-delay=".5s">
                <table class="timetable_sub">
                    <thead>
                        <tr>
                            <th>@lang('cart.remove')</th>
                            <th>@lang('cart.image')</th>
                            <th>@lang('cart.quantity')</th>
                            <th>@lang('cart.name')</th>
                            <th>@lang('cart.price')</th>
                        </tr>
                    </thead>
                    <?php
                      $count = count($data);
                      $cart_array = [];
                      foreach ($data as $cart) {
                        array_push($cart_array, $cart['cart_id']);
                      }
                      $cart_string = implode(",",$cart_array);
                    ?>
                    @foreach ($data as $key => $show_body)
                    
                        <tr class="{{ "rem".$show_body['cart_id'] }}">
                            <td class="invert-closeb">
                                <div class="rem">
                                    <div class="{{ "close".$show_body['cart_id'] }} remove_cart mx-auto" id="close" cart_id="{{$show_body['cart_id']}}"> </div>
                                </div>
                            </td>
                            <td class="invert-image">
                            	<a href="single.html">
                            		<img src="{{ asset('storage/'.$show_body['image']) }}" alt=" " class="img-responsive" />
                            	</a>
                            </td>
                            <td class="invert">
                                <div class="quantity">
                                    <div class="quantity-select">
                                        <div class="entry value-minus" cart_id="{{$show_body['cart_id']}}">&nbsp;</div>
                                        <div class="entry value">
                                        	<span class="new_quantity">{{ $show_body['quantity'] }}</span>
                                        </div>
                                        <div class="entry value-plus active" cart_id="{{$show_body['cart_id']}}">&nbsp;</div>
                                    </div>
                                </div>
                            </td>
                            @if(app()->getLocale() == 'ur')
                                <td class="invert">{{ $show_body['name_urdu'] }}</td>
                            @elseif(app()->getLocale() == 'ar')
                                <td class="invert">{{ $show_body['name_arabic'] }}</td>
                            @else
                                <td class="invert">{{ $show_body['name'] }}</td>
                            @endif
                            <td class="invert price_class">${{ $show_body['price'] }} * <span id="cart-id-{{$show_body['cart_id']}}"> {{ $show_body['quantity'] }} </span></td>
                        </tr>
                    @endforeach
                </table>
            </div>
            @if ($count>0)
              <div class="row">
                <div class="col-md-6">
                  <div class="button">
                    <div class="continue-delivery">
                      <div class="red_button shop_now_button">
                      	<a href="{{ url('/') }}" class="btn btn-success btn-sm">@lang('cart.continue_shop')</a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="button">
                    <div class="continue-delivery">
                      <div class="red_button shop_now_button float-right">
                      	<a href="{{ URL::to('/address') }}" class="btn btn-success btn-sm">
	                      	@lang('cart.add_delivery_details')
	                      </a>
	                  </div>
                    </div>
                  </div>
                </div>
              </div>
            @endif
        </div>
</main>
@endsection
@section('front-additional-js')
<script type="text/javascript">

    var cart_string = "{{ $cart_string }}";
    
    var cart_array = cart_string.split(",");

    var locale = "{{ app()->getLocale() }}";
    var main_url = "{{ env("MAIN_HOST_URL") }}";
    console.log(locale);

    $(document).ready(function(c) {

        if (cart_array != null) {
            $.each(cart_array, function(index, value) {
                $('.close' + value).on('click', function(c) {
                    $('.rem' + value).fadeOut('slow', function(c) {
                        $('.rem' + value).remove();
                    });
                });
            });
        }

        $(".remove_cart").click(function() {

            var cart_id = $(this).attr('cart_id');

            if(locale == 'en'){
                var url = main_url+"/ajax-delete-cart";
            }else{
                var url = main_url+'/'+locale+"/ajax-delete-cart";
            }


            $.ajax({
                type: 'POST',
                url: url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'cart_id': cart_id
                },
                success: function(data) {
                  location.reload(true);
                }

            });
        });


        var new_quantity;

        $('.value-plus').on('click', function() {
            var divUpd = $(this).parent().find('.value'),
                newVal = parseInt(divUpd.text(), 10) + 1;
            divUpd.text(newVal);
            

            new_quantity = newVal;

            if(locale == 'en'){
                var url = main_url+"/ajax-update-quantity-cart";
            }else{
                var url = main_url+'/'+locale+"/ajax-update-quantity-cart";
            }

            var cart_id = $(this).attr('cart_id');
            console.log(cart_id);
            $.ajax({
                type: 'POST',
                url: url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'cart_id': cart_id,
                    'new_quantity': new_quantity
                },
                success: function(data) {
                    console.log(data);
                    $('#cart-id-'+cart_id).html(data.new_quantity);
                        location.reload(true);
                }

            });
        });

        $('.value-minus').on('click', function() {
            var divUpd = $(this).parent().find('.value'),
                newVal = parseInt(divUpd.text(), 10) - 1;
            if (newVal >= 1) {
                divUpd.text(newVal);
                new_quantity = newVal;
                
            }
            
            if(locale == 'en'){
                var url = main_url+"/ajax-update-quantity-cart";
            }else{
                var url = main_url+'/'+locale+"/ajax-update-quantity-cart";
            }

            var cart_id = $(this).attr('cart_id');
            if (new_quantity >= 1) {
                $.ajax({
                    type: 'POST',
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        'cart_id': cart_id,
                        'new_quantity': new_quantity
                    },
                    success: function(data) {
                        console.log(data);
                        $('#cart-id-'+cart_id).html(data.new_quantity);
                        location.reload(true);
                    }

                });
            }

        });
    });
</script>
@endsection