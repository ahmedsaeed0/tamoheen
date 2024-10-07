@extends('layouts.admin.master')
@section('title')
PartnerPaymentMethod {{ $partnerpaymentmethod->id }}
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
                        <h4 class="card-title ">{{ __('admin-payment-method.partner_payment_method')}} {{ $partnerpaymentmethod->id }}</h4>
                        <a  href="{{ url('/partner-payment-methods') }}" class="btn btn-primary"> {{ __('admin-payment-method.back')}} </a>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>ID</th>
                                        <td>{{ $partnerpaymentmethod->id }}</td>
                                    </tr>
                                    <tr>
                                        <th> {{ __('admin-payment-method.user')}}  </th>
                                        <td> {{ $partnerpaymentmethod->users->name }} </td>
                                    </tr>
                                    <tr>
                                        <th> {{ __('admin-payment-method.name')}}  </th>
                                        <td> {{ $partnerpaymentmethod->name }} </td>
                                    </tr>
                                    <tr>
                                        <th> {{ __('admin-payment-method.details')}}  </th>
                                        <td> {{ $partnerpaymentmethod->details }} </td>
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
