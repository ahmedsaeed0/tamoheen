@extends('layouts.admin.master')
@section('title')
Service Charge {{ $servicecharge->id }}
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
                        <h4 class="card-title ">{{ __('admin-charge.show_service_charge') }} {{ $servicecharge->id }}</h4>
                        <a  href="{{ url('/service-charges') }}" class="btn btn-primary"> {{ __('admin-charge.back') }}</a>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>{{ __('admin-charge.id') }}</th>
                                        <td>{{ $servicecharge->id }}</td>
                                    </tr>
                                    <tr>
                                        <th> {{ __('admin-charge.type') }} </th>
                                        <td>
                                            @if($servicecharge->type == 0)
                                                <span class="badge badge-success">{{ __('admin-charge.trip') }}</span>
                                            @else
                                                <span class="badge badge-success">{{ __('admin-charge.shipment') }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th> {{ __('admin-charge.charge') }} </th>
                                        <td> {{ $servicecharge->charge }} </td>
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
