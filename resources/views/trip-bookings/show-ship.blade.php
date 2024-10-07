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
                        <h4 class="card-title ">ShipmentBooking {{ $tripbooking->id }}</h4>
                        <a href="{{ url('/ship-bookings') }}" class="btn btn-primary"> Back</a>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>ID</th>
                                        <td>{{ $tripbooking->id }}</td>
                                    </tr>
                                    <tr>
                                        <th> User </th>
                                        <td> {{ $tripbooking->user->name }} </td>
                                    </tr>
                                    <tr>
                                        <th> Trip </th>
                                        <td> {{ $tripbooking->trip->title }} </td>
                                    </tr>
                                    @role('admin')
                                    <tr>
                                        <th> Trip Price </th>
                                        <td> {{ $tripbooking->trip->price_per_bag }} </td>
                                    </tr>
                                    @endrole
                                    <tr>
                                        <th> Number Of Bag </th>
                                        <td> {{ $tripbooking->number_of_bag }} </td>
                                    </tr>
                                    @role('admin')
                                    <tr>
                                        <th> User Price </th>
                                        <td> {{ $tripbooking->price }} </td>
                                    </tr>
                                    @endrole
                                    <tr>
                                        <th> Partner Price </th>
                                        <td> {{ $tripbooking->partner_price }} </td>
                                    </tr>
                                    <tr>
                                        <th> Is payment complete </th>
                                        <td>
                                            @if($tripbooking->is_payment_complete == 1)
                                                <span class="badge badge-success">Complete</span>
                                            @else
                                                <span class="badge badge-danger">Incomplete</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Receiver Name</th>
                                        <td>{{ $tripbooking->sender_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Receiver Mobile</th>
                                        <td>{{ $tripbooking->sender_phone }}</td>
                                    </tr>
                                    <tr>
                                        <th>Receiver Address</th>
                                        <td>{{ $tripbooking->sender_address }}</td>
                                    </tr>
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