@extends('layouts.admin.master')
@section('title')
TripBooking {{ $tripbooking->id }}
@endsection
@section('admin-additional-css')
<style type="text/css">
    .card .table tr:first-child td {
        border-top: 1px solid #ddd;
    }
</style>
@endsection
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">{{ __('admin-trip-booking.trip_bookings')}} {{ $tripbooking->id }}</h4>
                        <a href="{{ url('/trip-bookings') }}" class="btn btn-primary"> {{ __('admin-trip-booking.back')}}</a>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>{{ __('admin-trip-booking.id')}}</th>
                                        <td>{{ $tripbooking->id }}</td>
                                    </tr>
                                    <tr>
                                        <th> {{ __('admin-trip-booking.user')}} </th>
                                        <td> {{ $tripbooking->user->name }} </td>
                                    </tr>
                                    <tr>
                                        <th> {{ __('admin-trip-booking.trip')}} </th>
                                        <td> {{ $tripbooking->trip->title }} </td>
                                    </tr>
                                    @role('admin')
                                    <tr>
                                        <th> {{ __('admin-trip-booking.trip_price')}} </th>
                                        <td> {{ $tripbooking->trip->price_per_person }} </td>
                                    </tr>
                                    @endrole
                                    <tr>
                                        <th> {{ __('admin-trip-booking.no_of_passengers')}} </th>
                                        <td> {{ $tripbooking->number_of_passengers }} </td>
                                    </tr>
                                    @role('admin')
                                    <tr>
                                        <th> {{ __('admin-trip-booking.user_price')}} </th>
                                        <td> {{ $tripbooking->price }} </td>
                                    </tr>
                                    @endrole
                                    <tr>
                                        <th> {{ __('admin-trip-booking.partner_price')}} </th>
                                        <td> {{ $tripbooking->partner_price }} </td>
                                    </tr>
                                    <tr>
                                        <th> {{ __('admin-trip-booking.payment_method')}}  </th>
                                        <td> {{ ucfirst($tripbooking->payment_method) ?? '' }} </td>
                                    </tr>
                                    <tr>
                                        <th> {{ __('admin-trip-booking.payment_complete')}} </th>
                                        <td>
                                            @if($tripbooking->is_payment_complete == 1)
                                                <span class="badge badge-success">{{ __('admin-trip-booking.complete')}}</span>
                                            @else
                                                <span class="badge badge-danger">{{ __('admin-trip-booking.incomplete')}}</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th> {{ __('admin-trip-booking.status') }} </th>
                                        <td>
                                            @if($tripbooking->status == 1)
                                                <span class="badge badge-success">{{ __('admin-trip-booking.incomplete')}}</span>
                                            @elseif($tripbooking->status == 2)
                                                <span class="badge badge-primary">{{ __('admin-trip-booking.checked_in')}}</span>
                                            @elseif($tripbooking->status == 0)
                                                <span class="badge badge-info">{{ __('admin-trip-booking.cancel')}}</span>
                                            @elseif($tripbooking->status == 3)
                                                <span class="badge badge-info">{{ __('admin-trip-booking.checked_out')}}</span>
                                            @else
                                                <span class="badge badge-success">{{ __('admin-trip-booking.completed')}}</span>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">{{ __('admin-trip-booking.passengers')}}</h4>
                    </div>
                    <div class="card-body">

                    <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('admin-trip-booking.name')}}</th>
                                        <th>{{ __('admin-trip-booking.email')}}</th>
                                        <th>{{ __('admin-trip-booking.mobile')}}</th>
                                        <th>{{ __('admin-trip-booking.identity_type')}}</th>
                                        <th>{{ __('admin-trip-booking.identity_number')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($passengers as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->mobile }}</td>
                                        <td>
                                            @if($item->identity_type == 1)
                                                <span class="badge badge-success">{{ __('admin-trip-booking.nid')}}</span>
                                            @else
                                                <span class="badge badge-success">{{ __('admin-trip-booking.passport')}}</span>
                                            @endif
                                        </td>
                                        <td><?= substr($item->identity_number,0,5).'XXXX'?></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
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
