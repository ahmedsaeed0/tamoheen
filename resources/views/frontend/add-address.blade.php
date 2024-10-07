@extends('layouts.front.master')
@section('title')
Cart List
@endsection
@section('front-additional-css')
<link rel="stylesheet" type="text/css" href="{{ asset('front/assets/css/add-address.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('front/assets/css/util.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('front/assets/css/main.css')}}">
@endsection
@section('content')
@include('layouts.front.include.header1')
<main id="content">
  <div class="container signup_section_container">
      <div class="container-login100">
          <div class="wrap-login100 p-l-55 p-r-55 p-t-80 p-b-30">
            @if(app()->getLocale() == 'ur')
              <form class="login100-form validate-form" action="{{ URL('ur/address-submit') }}" method="post">
            @elseif(app()->getLocale() == 'ar')
              <form class="login100-form validate-form" action="{{ URL('ar/address-submit') }}" method="post">
            @else
              <form class="login100-form validate-form" action="{{ URL('/address-submit') }}" method="post">
            @endif
                  @csrf
                  <span class="login100-form-title p-b-37">
                      @lang('add-address.delivery_details')
                  </span>


                  <div class="wrap-input100 validate-input m-b-20">
                      <input class="input100" type="text" name="flat_no" placeholder="@lang('add-address.flat_no')">
                      <span class="focus-input100"></span>
                  </div>
                  <div class="wrap-input100 validate-input m-b-20">
                      <input class="input100" type="text" name="location" placeholder="@lang('add-address.location')">
                      <span class="focus-input100"></span>
                  </div>

                  <div class="wrap-input100 validate-input m-b-20">
                      <div class="select-style">
                        @if(app()->getLocale() == 'ur')
                        <select id="country_id" class="country_id" name="country_id">
                          <option class="country_option" disable>@lang('add-address.select_country')</option>
                            @foreach ($countries as $show_country)
                              <option class="country_option" value="{{ $show_country->id }}">{{ $show_country->name_urdu }}</option>
                            @endforeach
                        </select>
                        @elseif(app()->getLocale() == 'ar')

                        <select id="country_id" class="country_id" name="country_id">
                          <option class="country_option" disable>@lang('add-address.select_country')</option>
                            @foreach ($countries as $show_country)
                              <option class="country_option" value="{{ $show_country->id }}">{{ $show_country->name_arabic }}</option>
                            @endforeach
                        </select>
                        @else
                          <select id="country_id" class="country_id" name="country_id">
                          <option class="country_option" disable>@lang('add-address.select_country')</option>
                            @foreach ($countries as $show_country)
                              <option class="country_option" value="{{ $show_country->id }}">{{ $show_country->name }}</option>
                            @endforeach
                        </select>
                        @endif
                      </div>
                  </div>

                  <div class="wrap-input100 validate-input m-b-20">
                      <div class="select-style">
                        <select class="state_id" name="state_id">

                        </select>
                      </div>
                  </div>

                  <div class="wrap-input100 validate-input m-b-20">
                      <div class="select-style">
                        <select class="city_id" name="city_id">

                        </select>
                      </div>
                  </div>

                  <div class="wrap-input100 validate-input m-b-20">
                      <input class="input100" type="text" name="pin_code" placeholder="@lang('add-address.pin_code')">
                      <span class="focus-input100"></span>
                  </div>
                  <div class="wrap-input100 validate-input m-b-20">
                      <input class="input100" type="text" name="phone_no" placeholder="@lang('add-address.phone')">
                      <span class="focus-input100"></span>
                  </div>
                  <div class="container-login100-form-btn">
                      <button class="login100-form-btn" type="submit">
                          @lang('add-address.add_detail')
                      </button>
                  </div>
              </form>
          </div>
      </div>
  </div>
</main>
@endsection
@section('front-additional-js')
<script type="text/javascript">
var locale = "{{ app()->getLocale() }}";
var main_url = "{{ env("MAIN_HOST_URL") }}";

$('.country_id').on('change',function() {
  var state_html = '<option disable>SELECT STATE</option>';

  var country_id = $('.country_id').val();

  if(locale == 'en'){
      var url = main_url+"/ajax-state-list";
  }else{
      var url = main_url+'/'+locale+"/ajax-state-list";
  }

  $.ajax({
    type: 'POST',
    url: url,
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    data: {
      'country_id': country_id
    },
    success: function(data) {
      $.each(data, function(index, value ){
        state_html = state_html + '<option value="'+value.id+'">'+value.name+'</option>'
      });
      $('.state_id').html(state_html);
    }

  });
  });



$('.state_id').on('change',function() {

  var city_html = '<option disable>SELECT CITY</option>';

  var state_id = $('.state_id').val();
  
  if(locale == 'en'){
      var url = main_url+"/ajax-city-list";
  }else{
      var url = main_url+'/'+locale+"/ajax-city-list";
  }

  $.ajax({
    type: 'POST',
    url: url,
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    data: {
      'state_id': state_id
    },
    success: function(data) {
      $.each(data, function(index, value ){
        city_html = city_html + '<option value="'+value.id+'">'+value.name+'</option>'
      });
      $('.city_id').html(city_html);
    }

  });
});



</script>
@endsection