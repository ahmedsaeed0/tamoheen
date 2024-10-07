@extends('layouts.admin.master')
@section('title')
Order {{ $order->id }}
@endsection
@section('admin-additional-css')
<style type="text/css">
    #user_image{
        opacity: 1 !important;
        position: unset;
    }
    #userImg{
        width: 100px;
        height: 100px;
    }
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
                        <h4 class="card-title ">{{ __('admin-order.show_order') }} {{ $order->id }}</h4>
                        <a  href="{{ url('/orders') }}" class="btn btn-primary"> {{ __('admin-order.back
                        ') }}</a>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>{{ __('admin-order.id') }}</th>
                                        <td>{{ $order->id }}</td>
                                    </tr>
                                    <tr>
                                        <th> {{ __('admin-order.user') }} </th>
                                        <td> {{ $order->user->name }} </td>
                                    </tr>
                                    <tr>
                                        <th> {{ __('admin-order.city') }} </th>
                                        <td> {{ $order->city->name }} </td>
                                    </tr>
                                    <tr>
                                        <th> {{ __('admin-order.total_price') }} </th>
                                        <td> {{ $order->total_price }} </td>
                                    </tr>

                                    @if($order->discount_amount != null)
                                    <tr>
                                        <th> {{ __('admin-order.discount_amount') }} </th>
                                        <td> {{ $order->discount_amount }} </td>
                                    </tr>
                                    @endif

                                    @if($order->discount_percent != null)
                                    <tr>
                                        <th> {{ __('admin-order.discount_percent') }} </th>
                                        <td> {{ $order->discount_percent.'%' }} </td>
                                    </tr>
                                    @endif

                                    <tr>
                                        <th> {{ __('admin-order.final_price') }} </th>
                                        <td> {{ $order->final_price }} </td>
                                    </tr>
                                    <tr>
                                        <th> {{ __('admin-order.payment_method') }} </th>
                                        <td> {{ $order->payment_method }} </td>
                                    </tr>
                                    <tr>
                                        <th> {{ __('admin-order.estimated_time') }} </th>
                                        <td> {{ $order->estimated_time }} </td>
                                    </tr>
                                    <tr>
                                        <th> {{ __('admin-order.status') }} </th>
                                        <td>
                                            @if($order->order_status == 1)
                                                <span class="badge badge-success">{{ __('admin-order.pending') }}</span>
                                            @elseif($order->order_status == 2)
                                                <span class="badge badge-success">{{ __('admin-order.accepted') }}</span>
                                            @elseif($order->order_status == 3)
                                                <span class="badge badge-success">{{ __('admin-order.on_going') }}</span>
                                            @else
                                                <span class="badge badge-success">{{ __('admin-order.delivered') }}</span>
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
                        <h4 class="card-title ">{{ __('admin-order.product_list') }}</h4>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('admin-order.name') }}</th>
                                        <th>{{ __('admin-order.price') }}</th>
                                        <th>{{ __('admin-order.user_get_qty') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->cartOrders as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->product->name }}</td>
                                        <td>{{ $item->product->price }}</td>
                                        <td>{{ $item->quantity }}</td>
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
