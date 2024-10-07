@extends('layouts.admin.master')
@section('title')
Sliders
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
                        <h4 class="card-title ">{{ __('wallet-ts.wallet_manage') }}</h4>
                        <a href="{{url('/export-excel/wallets-manage')}}"><button class="btn btn-success btn-sm" data-target="trip">Export<div class="ripple-container"></div></button></a>
                    </div>
                    <div class="card-body">

                    <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('wallet-ts.title') }}</th>
                                        {{-- <th>Title Urdu</th> --}}
                                        <th style="max-width: 100px;">{{ __('wallet-ts.returning') }}</th>
                                        <th>{{ __('Partner Name') }}</th>
                                        <th>{{ __('admin-sliders.b-name') }}</th>
                                        <th>{{ __('admin-sliders.trip-no') }}</th>
                                        <th>{{ __('admin-sliders.actions') }}</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($partnerAmount as $key => $value)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{$value->total_amount}}</td>
                                        {{-- <td>{{ $item->title_urdu }}</td> --}}
                                        <td>{{ $value->amount }}</td>
                                     
                                        <td>{{ $value->nickname }}</td>
                                        <td>{{ $value->brand_name }}</td>
                                       <td>{{ App\Http\Controllers\EwalletsController::getTrip($value->partner_id) }} </td>
                                        
                                       
                                     
                                        <td>
                                            @if($value->status == 1)
                                                <a  title="Settled">
                                                    completed
                                                </a>
                                            @else
                                                <a href="{{ url('settle-amount/'.$value->id) }}" title="{{ __('admin-sliders.edit_slider') }}" class="btn btn-info btn-sm">
                                                    Settle
                                                </a>
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
