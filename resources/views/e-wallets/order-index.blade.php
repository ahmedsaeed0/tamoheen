@extends('layouts.admin.master')
@section('title')
Orders
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
                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">Orders</h4>
                        @if(count($orders) < 0)
                            <span class="float-right">Total Price: ${{ '0' }}</span>
                        @else
                            <span class="float-right">Total Price: $ {{ $orders->sum('final_price') }}</span>
                        @endif

                    </div>
                    <div class="card-body">

                    <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Method</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($orders as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->user->name }}</td>
                                        <td>{{ $item->final_price }}</td>
                                        <td>{{ $item->payment_method }}</td>
                                        <td>
                                            @if($item->order_status == 1)
                                                <span class="badge badge-success">Pending</span>
                                            @elseif($item->order_status == 2)
                                                <span class="badge badge-success">Accepted</span>
                                            @elseif($item->order_status == 3)
                                                <span class="badge badge-success">On Going</span>
                                            @else
                                                <span class="badge badge-success">Delivered</span>
                                            @endif
                                        </td>
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