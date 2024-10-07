@extends('layouts.admin.master')

@section('title')

Tripbookings

@endsection

@section('admin-additional-css')

@endsection

@section('content')

<div class="content">

    @include('layouts.admin.include.alert')

    <div class="container-fluid">

        <div class="row">

            <div class="col-md-12">

                <div class="card">

                    <div class="card-header card-header-primary d-flex justify-content-between align-items-center">

                        <h4 class="card-title ">{{ __('admin-trip-booking.trip_bookings')}}</h4>

                        <a href="{{url('/export-excel/trip-booking')}}"><button class="btn btn-success btn-sm" data-target="trip">Export</button></a>

                    </div>


                   

                    <div class="card-body">

                        @foreach($tripbookings as $item)
                    
                        <?php

                        $sql = "SELECT *,from_city.name as from_en,from_city.name_arabic AS from_ar, 

                                to_city.name AS to_en,to_city.name_arabic AS to_ar

                                FROM trips t

                                LEFT JOIN cities from_city ON from_city.id = t.city_from_id

                                LEFT JOIN cities to_city ON to_city.id = t.city_to_id

                                WHERE t.id = " . $item->trip_id;

                        $results = DB::select($sql);

                        Lang::locale();

                        ?>

                        <div class="card">

                            <div class="card-body">

                                <div class="row">

                                    <div class="col-md-12">

                                        <div class="row">

                                            <div class="col-md-4">

                                                <p>{{ __('admin-trip-booking.user')}} : {{ $item->user ? $item->user->name : '' }}</p>


                                                <?php if(isset($item->trip->title)){ ?>
                                                    <p>{{ __('admin-trip-booking.trip')}} : {{ $item->trip->title }}</p>
                                                <?php } ?>
                                                <p>{{ __('admin-trip-booking.route')}}:

                                                    <?php if (Lang::locale() == 'en') { ?>
                                                        <?php if(isset($results[0]->from_en) && isset($results[0]->to_en)){ ?>
                                                            {{ $results[0]->from_en }} - {{ $results[0]->to_en }}
                                                        <?php } ?>
                                                    <?php } else { ?>
                                                        <?php if(isset($results[0]->from_ar) && isset($results[0]->to_ar)){ ?>
                                                            {{ $results[0]->from_ar }} - {{ $results[0]->to_ar }}
                                                        <?php } ?>
                                                    <?php } ?>

                                                </p>
                                                <?php if(isset($results[0]->date)){ ?>
                                                    <p>{{ __('admin-trip-booking.trip_date')}} : {{ $results[0]->date }}</p>
                                                <?php } ?>


                                            </div>

                                            <div class="col-md-4">

                                                <p>{{ __('admin-trip-booking.number_of_passengers')}} : {{ $item->number_of_passengers }}</p>

                                                @role('admin')

                                                <p>{{ __('admin-trip-booking.user_price')}} : {{ $item->price }}</p>

                                                @endrole

                                                <p>{{ __('admin-trip-booking.partner_price')}} : {{ $item->partner_price }}</p>

                                            </div>

                                            <div class="col-md-4">

                                                <p>{{ __('admin-trip-booking.payment_complete')}} :

                                                    @if($item->is_payment_complete == 1)

                                                    <span class="badge badge-success">{{ __('admin-trip-booking.complete') }}</span>

                                                    @else

                                                    <span class="badge badge-danger">{{ __('admin-trip-booking.incomplete') }}</span>

                                                    @endif

                                                </p>

                                                <p>{{ __('admin-trip-booking.booking_status')}} :

                                                    @if($item->status == 1 && $item->is_payment_complete == 1)

                                                    <span class="badge badge-success">{{ __('admin-trip-booking.success') }}</span>

                                                    @elseif($item->status == 1 && $item->is_payment_complete == 0)

                                                    <span class="badge badge-success">{{ __('admin-trip-booking.pending') }}</span>

                                                    @elseif($item->status == 2)

                                                    <span class="badge badge-primary">{{ __('admin-trip-booking.checked_in') }}</span>

                                                    @elseif($item->status == 3)

                                                    <span class="badge badge-info">{{ __('admin-trip-booking.checked_out') }}</span>

                                                    @elseif($item->status == 0)

                                                    <span class="badge badge-info">{{ __('admin-trip-booking.cancel') }}</span>

                                                    {{$item->cancelled_by }}

                                                    {{$item->cancel_date}}

                                                    @else

                                                    <span class="badge badge-success">

                                                        {{ __('admin-trip-booking.completed') }}

                                                    </span>

                                                    @endif

                                                </p>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-12">

                                        <div class="row">

                                            <div class="col-md-12">

                                                <a href="{{ url('/trip-bookings/' . $item->id) }}" title="{{ __('admin-trip-booking.view_trip_booking')}}" class="btn btn-info btn-sm">

                                                    <i class="material-icons">

                                                        remove_red_eye

                                                    </i>

                                                </a>

                                                @role('partner')

                                                @if($item->is_payment_complete == 1 && $item->check_in == null)

                                                <a href="{{ url('/check-in/' . $item->id) }}" title="{{ __('admin-trip-booking.check_in_trip_booking')}}" class="btn btn-info btn-sm">

                                                    {{ __('admin-trip-booking.check_in')}}

                                                </a>

                                                <a href="{{ url('/direct-check-in/' . $item->id) }}" title="{{ __('admin-trip-booking.check_in_trip_booking')}}" class="btn btn-info btn-sm">

                                                    {{ __('admin-trip-booking.direct_check_in')}}

                                                </a>

                                                @endif



                                                @if($item->is_payment_complete == 1 && $item->check_in != null && $item->check_out == null)

                                                <a href="{{ url('/check-out/' . $item->id) }}" title="{{ __('admin-trip-booking.view_trip_booking')}}" class="btn btn-info btn-sm">

                                                    {{ __('admin-trip-booking.check_out')}}

                                                </a>

                                                @endif



                                                @if($item->is_payment_complete == 1 && $item->status == 3)

                                                <a href="{{ url('trip-booking-complete/' . $item->id) }}" title="{{ __('admin-trip-booking.check_out_trip_booking')}}" class="btn btn-info btn-sm">

                                                    {{ __('admin-trip-booking.trip_complete')}}

                                                </a>

                                                @endif

                                                @if(app()->getLocale() == 'ur')

                                                {!! html()->form('DELETE', url('/ur/trip-bookings/' . $item->id), ['style' => 'display:inline'])->open() !!}


                                                @elseif(app()->getLocale() == 'ar')

                                                {!! html()->form('DELETE', url('/ar/trip-bookings/' . $item->id), ['style' => 'display:inline'])->open() !!}


                                                @else

                                                {!! html()->form('DELETE', url('/trip-bookings/' . $item->id), ['style' => 'display:inline'])->open() !!}


                                                @endif

                                                {!! html()->form('DELETE', url('/trip-bookings', $item->id), ['style' => 'display:inline'])->open() !!}

                                                {!! html()->button()
                                                    ->attribute('type', 'submit')
                                                    ->attribute('class', 'btn btn-danger btn-sm')
                                                    ->attribute('title', __('admin-trip-booking.delete_trip_booking'))
                                                    ->attribute('onclick', 'return confirm("Confirm delete?")')
                                                    ->html('<i class="material-icons" aria-hidden="true">delete</i>') !!}

                                                {!! html()->form()->close() !!}


                                                @endrole

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                        @endforeach
                        
                        <style>
                            
                            .pagination-wrapper svg {
                                display: none;
                            }
                            </style>
                        <div class="pagination-wrapper"> {!! $tripbookings->appends(['search' => Request::get('search')])->render() !!} </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

</div>

@endsection

@section('admin-additional-js')



@endsection