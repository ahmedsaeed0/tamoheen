@extends('layouts.admin.master')
@section('title')
TripBookings
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
                        <div><h4 class="card-title ">{{ __('admin-trip-wallet.tripbookings') }}</h4></div>
                        <div class="d-flex align-items-center">
                            @if(count($tripbookings) < 0)
                                <span class="float-right mx-4">{{ __('admin-trip-wallet.total_price') }}: ${{ '0' }}</span>
                            @else
                                <span class="float-right mx-4">{{ __('admin-trip-wallet.total_price') }}: $ {{ $tripbookings->sum('price') }}</span>
                            @endif
                            <a href="{{url('/export-excel/trip-wallets')}}"><button class="btn btn-success btn-sm" data-target="trip">Export<div class="ripple-container"></div></button></a>
                        </div>
                        
                        
                    </div>
                    @foreach($tripbookings as $item)
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p>{{ __('admin-trip-wallet.name') }} : {{ $item->user ? $item->user->name : 'User' }}</p>

                                        <p>{{ __('admin-trip-wallet.price') }} : {{ $item->price }}</p>
                                            
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{ __('admin-trip-wallet.method') }} : {{ $item->payment_method }}</p>
                                        <p>{{ __('admin-trip-wallet.status') }} : 
                                            @if($item->is_payment_complete == 1)
                                                <span class="badge badge-success">{{ __('admin-trip-wallet.complete') }}</span>
                                            @else
                                                <span class="badge badge-danger">{{ __('admin-trip-wallet.pending') }}</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('admin-additional-js')

@endsection
