@extends('layouts.admin.master')
@section('title')
WithdrawRequest {{ $withdrawrequest->id }}
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
                        <h4 class="card-title ">WithdrawRequest {{ $withdrawrequest->id }}</h4>
                        <a  href="{{ url('/withdraw-requests') }}" class="btn btn-primary"> Back</a>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $withdrawrequest->id }}</td>
                                    </tr>
                                    <tr><th> Partner Id </th><td> {{ $withdrawrequest->partner_id }} </td></tr><tr><th> Payment Method </th><td> {{ $withdrawrequest->payment_method }} </td></tr><tr><th> Amount </th><td> {{ $withdrawrequest->amount }} </td></tr>
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