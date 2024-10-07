@php
echo App\Http\Controllers\FrontendsController::updateTripPerson($tripbooking->trip->id,$tripbooking->id);
@endphp
@extends('layouts.front.master')
@section('title')
Payment
@endsection
@section('front-additional-css')
@if(app()->getLocale() == 'ar')
    <style>
        #object-contain{
            float: right;
        }

        #qrcode{
            /*float: right;*/
            margin-bottom: 15px;
        }
    </style>
@else
    <style>

        #logo{
            /*float: right;*/
        }
    </style>
@endif
@endsection
@section('content')
@include('layouts.front.include.header1')
<main id="content" class="bg-gray space-2">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12  col-lg-8  ">
                <div class="mb-5 shadow-soft bg-white rounded-sm">
                    <div class="py-3 px-4 px-xl-12 border-bottom">
                        <h2 class="text-center">@lang('content.boarding_info')</h2>
                    </div>
                    <div class="pt-4 pb-5 px-5">
                        {{-- <h3 id="scroll-description" class="font-size-21 font-weight-bold text-success mb-4 text-center">
                           @lang('content.payment_succ')
                        </h3> --}}
                        <div class="row" style="text-align: center;">
                            <div class="col-12 col-md-6">
                                <div class="mb-4">
                                    <img id="qrcode"  width="140px" src="{{ asset('public'.$image) }}" alt="" srcset="">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="mb-4">
                                    <img id="logo" width="200" src="{{ asset('front/assets/images/logo.png') }}" alt="" srcset="">
                                </div>
                            </div>
                        </div>
                        {{-- <div>
                           <img class="object-contain"  width="140px" src="{{ asset('front/assets/images/logo.png') }}" alt="" srcset="">
                        </div> --}}
                        <!-- Tab Content -->
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="paytab" role="tabpanel" aria-labelledby="pills-one-example2-tab">
                                    <div class="row justify-content-around">
                                        {{-- <div class="card">
                                            <div class="card-body">
                                               <h3>@lang('content.trip_booking_id'): {{ $tripbooking->id }}</h3>
                                               @if(app()->getLocale() == 'ur')
                                               <p><b>@lang('content.trip_title'):</b> {{ $tripbooking->trip->title_urdu }}</p>
                                               @elseif(app()->getLocale() == 'ar')
                                                    <p><b>@lang('content.trip_title'):</b> {{ $tripbooking->trip->title_arabic }}</p>
                                               @else
                                                    <p><b>@lang('content.trip_title'):</b> {{ $tripbooking->trip->title }}</p>
                                               @endif
                                            </div>
                                        </div> --}}


                                       <div style="width: 100%" class=" w-full">
                                           <div >
                                               <div class="row justify-content-center">
                                                   <table style="max-width: 760px" class="table table-bordered">
                                                    {{-- <thead>
                                                        
                                                        @foreach($passengers as $d)
                                                            <tr>
                                                          <th scope="col">Name</th>
                                                          <th scope="col">ID</th>
                                                          </tr>
                                                          @endforeach
                                                          <tr>
                                                          <th scope="col">Start Point</th>
                                                          <th scope="col">Driver Phone</th>
                                                        </tr>
                                                      </thead> --}}
                                                      <tbody class="text-center">
                                                        
                                                          @foreach($passengers as $d)
                                                          <tr>
                                                              <td>@lang('content.name')</td>
                                                              <td>{{ $d->name ?? '' }}</td>
                                                            </tr>
                                                            <tr>
                                                            <td>Trip Price</td>
                                                            <td>{{ $tripbooking->price ?? '' }}</td>
                                                        </tr>
                                                            <tr>
                                                              <td>@lang('content.id')</td>
                                                              <td>{{  $d->identity_number ?? '' }}</td>
                                                            </tr>
                                                           @endforeach
                                                           <?php //echo "<pre>"; print_r($tripbooking); die; ?>
                                                        <tr>
                                                            <td>Trip No</td>
                                                            <td>{{ $tripbooking->trip->id ?? '' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Trip Name</td>
                                                            <td>{{ $tripbooking->trip->title ?? '' }}</td>
                                                        </tr>
                                                        
                                                        <tr>
                                                            <td>@lang('content.start_point')</td>
                                                            <td>{{ $tripbooking->trip->start_point ?? '' }}</td>
                                                        </tr>

                                                          <tr>
                                                            <td>@lang('content.end_point')</td>
                                                            <td>{{ $tripbooking->trip->end_point ?? '' }}</td>
                                                          </tr>
                                                          <tr>
                                                            <td>@lang('content.driver_name')</td>
                                                            <td>{{ $tripbooking->trip->user->name ?? '' }}</td>
                                                          </tr>
                                                          <tr>
                                                            <td>@lang('content.driver_phone')</td>
                                                            <td>{{ preg_replace('/[+]/', "", $tripbooking->trip->user->mobile) ?? '' }}</td>
                                                          </tr>
                                                          <!--<tr>-->
                                                          <!--  <td>@lang('content.plate')</td>-->
                                                          <!--  <td>{{ $tripbooking->trip->cars->plate_number ?? '' }}</td>-->
                                                          <!--</tr>-->
                                                          
                                                          <tr>
                                                              <td>@lang('content.plate_type')</td>
                                                                <td>{{ $tripbooking->trip->cars->plate_letter_left ?? ' ' }} {{  $tripbooking->trip->cars->plate_letter_middle ?? ' '}} {{  $tripbooking->trip->cars->plate_letter_right   }} {{ $tripbooking->trip->cars->plate_number ?? '' }}</td>
                                                          </tr>

                                                          <tr>
                                                            <td>@lang('content.date')</td>
                                                            <td>{{ Carbon\Carbon::parse($tripbooking->trip->date)->format('Y-m-d') }}</td>
                                                          </tr>
                                                          <tr>
                                                            <td>@lang('content.time')</td>
                                                            <td>{{ Carbon\Carbon::parse($tripbooking->trip->date)->format('H:i A') }}</td>
                                                          </tr>
                                                          <tr>
                                                              <tD colspan="2">
                                                                  <a target="_blank" href="{{url('paytab-payment-success-pdf/'.$tripbooking->id)}}" class="btn btn-large btn-info">@lang('content.download')</a>
                                                              </tD>
                                                          </tr>

                                                      </tbody>
                                                   </table>

                                               </div>
                                           </div>
                                       </div>

                                    </div>
                            </div>
                        </div>
                        <!-- End Tab Content -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
@section('front-additional-js')
@endsection
