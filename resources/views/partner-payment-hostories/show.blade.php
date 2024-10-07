@extends('layouts.admin.master')
@section('title')
PartnerPaymentHostory {{ $partnerpaymenthostory->id }}
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
                        <h4 class="card-title ">{{ __('admin-payment-history.partner_payment_history') }} {{ $partnerpaymenthostory->id }}</h4>
                        <a  href="{{ url('/partner-payment-hostories') }}" class="btn btn-primary"> {{ __('admin-payment-history.back') }}</a>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>{{ __('admin-payment-history.id') }}</th>
                                        <td>{{ $partnerpaymenthostory->id }}</td>
                                    </tr>
                                    <tr>
                                        <th> {{ __('admin-payment-history.partner') }} </th>
                                        <td> {{ $partnerpaymenthostory->users->name }} </td>
                                    </tr>
                                    @if(($partnerpaymenthostory->type == 'Cash In'))
                                        @if($partnerpaymenthostory->trip_type == 'trip')
                                            <tr>
                                                <th> {{ __('admin-payment-history.booking_user') }}</th>
                                                <td> {{ $partnerpaymenthostory->tripBooking && $partnerpaymenthostory->tripBooking->user ? $partnerpaymenthostory->tripBooking->user->name : '' }} </td>

                                            </tr>
                                            <tr>
                                                <th> {{ __('admin-payment-history.trip_name') }} </th>
                                                <td> {{ $partnerpaymenthostory->tripBooking && $partnerpaymenthostory->tripBooking->trip ? $partnerpaymenthostory->tripBooking->trip->title : '' }} </td>

                                            </tr>
                                        @else
                                            <tr>
                                                <th> {{ __('admin-payment-history.booking_user') }}</th>
                                                <td> {{ $partnerpaymenthostory->shipBooking->user->name }} </td>
                                            </tr>
                                            <tr>
                                                <th> {{ __('admin-payment-history.trip_name') }} </th>
                                                <td> {{ $partnerpaymenthostory->shipBooking->trip->title }} </td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <th> {{ __('admin-payment-history.type') }}</th>
                                            <td> {{ $partnerpaymenthostory->type }} </td>
                                        </tr>
                                    @else
                                        <tr>
                                            <th> {{ __('admin-payment-history.type') }} </th>
                                            <td> {{ $partnerpaymenthostory->type }} </td>
                                        </tr>
                                    @endif
                                    @role('admin')
                                    <tr>
                                        <th> {{ __('admin-payment-history.price') }} </th>
                                        <td> {{ $partnerpaymenthostory->price }} </td>
                                    </tr>
                                    @endrole
                                    <tr>
                                        <th> {{ __('admin-payment-history.partner_price') }} </th>
                                        <td> {{ $partnerpaymenthostory->partner_price }} </td>
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
