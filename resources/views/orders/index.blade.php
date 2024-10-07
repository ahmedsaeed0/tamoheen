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
                        <h4 class="card-title ">{{ __('admin-order.orders') }}</h4>
                    </div>
                    <div class="card-body">

                    <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('admin-order.name') }}</th>
                                        <th>{{ __('admin-order.email') }}</th>
                                        <th>{{ __('admin-order.mobile') }}</th>
                                        <th>{{ __('admin-order.price') }}</th>
                                        <th>{{ __('admin-order.status') }}</th>
                                        <th>{{ __('admin-order.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($orders as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->user->name }}</td>
                                        <td>{{ $item->user->email }}</td>
                                        <td>{{ $item->user->mobile }}</td>
                                        <td>{{ $item->final_price }}</td>
                                        <td>
                                            @if($item->order_status == 1)
                                                <span class="badge badge-success">{{ __('admin-order.pending') }}</span>
                                            @elseif($item->order_status == 2)
                                                <span class="badge badge-success">{{ __('admin-order.accepted') }}</span>
                                            @elseif($item->order_status == 3)
                                                <span class="badge badge-success">{{ __('admin-order.on_going') }}</span>
                                            @else
                                                <span class="badge badge-success">{{ __('admin-order.delivered') }}</span>
                                            @endif
                                        </td>
                                        <td>

                                            <a href="{{ url('/orders/' . $item->id) }}" title="{{ __('admin-order.view_order') }}" class="btn btn-info btn-sm">
                                                <i class="material-icons">
                                                    remove_red_eye
                                                </i>
                                            </a>

                                            @if($item->order_status == 1)
                                                <a href="{{ url('order-accept/' . $item->id) }}" title="{{ __('admin-order.accept_order') }}" class="btn btn-info btn-sm">
                                                    {{ __('admin-order.accept') }}
                                                </a>
                                            @endif
                                            @if($item->order_status == 2)
                                                <a href="{{ url('order-ongoing/' . $item->id) }}" title="{{ __('admin-order.ongoing_order') }}" class="btn btn-info btn-sm">
                                                    {{ __('admin-order.ongoing') }}
                                                </a>
                                            @endif
                                            @if($item->order_status == 3)
                                                <a href="{{ url('order-delivery/' . $item->id) }}" title="{{ __('admin-order.delivered_order') }}" class="btn btn-info btn-sm">
                                                    {{ __('admin-order.delivery') }}
                                                </a>
                                            @endif
                                            @if(app()->getLocale() == 'ur')
                                            <form method="POST" action="{{ url('/ur/orders', $item->id) }}" style="display:inline">
                                                @csrf
                                                @method('DELETE')
                                        @elseif(app()->getLocale() == 'ar')
                                            <form method="POST" action="{{ url('/ar/orders', $item->id) }}" style="display:inline">
                                                @csrf
                                                @method('DELETE')
                                        @else
                                            <form method="POST" action="{{ url('/orders', $item->id) }}" style="display:inline">
                                                @csrf
                                                @method('DELETE')
                                        @endif
                                            <button type="submit" class="btn btn-danger btn-sm" title="{{ __('admin-order.delete_order') }}" onclick="return confirm('Confirm delete?')">
                                                <i class="material-icons" aria-hidden="true">delete</i>
                                            </button>
                                        </form>
                                        
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $orders->appends(['search' => Request::get('search')])->render() !!} </div>
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
