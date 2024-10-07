@extends('layouts.admin.master')
@section('title')
Servicecharges
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
                        <div>
                            <h4 class="card-title ">{{ __('admin-charge.service_charges') }}</h4>
                            <a  href="{{ url('/service-charges/create') }}" class="btn btn-primary"> {{ __('admin-charge.add_new_service_charges') }}</a>
                        </div>
                        <div><a href="{{url('/export-excel/service-charges')}}"><button class="btn btn-success btn-sm" data-target="trip">Export<div class="ripple-container"></div></button></a></div>
                        
                    </div>
                    <div class="card-body">

                    <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('admin-charge.type') }}</th>
                                        <th>{{ __('admin-charge.charge') }}</th>
                                        <th>{{ __('admin-charge.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($servicecharges as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @if($item->type == 0)
                                                <span class="badge badge-success">{{ __('admin-charge.trip') }}</span>
                                            @else
                                                <span class="badge badge-success">{{ __('admin-charge.shipment') }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $item->charge }}</td>
                                        <td>

                                            <a href="{{ url('/service-charges/' . $item->id) }}" title="{{ __('admin-charge.view_service_charge') }}" class="btn btn-info btn-sm">
                                                <i class="material-icons">
                                                    remove_red_eye
                                                </i>
                                            </a>

                                            <a href="{{ url('/service-charges/' . $item->id . '/edit') }}" title="{{ __('admin-charge.edit_service_charge') }}" class="btn btn-success btn-sm">
                                                <i class="material-icons">
                                                    edit
                                                </i>
                                            </a>
                                            @if(app()->getLocale() == 'ur')
                                            <form method="POST" action="/ur/service-charges/{{ $item->id }}" style="display:inline">
                                                @csrf
                                                @method('DELETE')
                                        @elseif(app()->getLocale() == 'ar')
                                            <form method="POST" action="/ar/service-charges/{{ $item->id }}" style="display:inline">
                                                @csrf
                                                @method('DELETE')
                                        @else
                                            <form method="POST" action="/service-charges/{{ $item->id }}" style="display:inline">
                                                @csrf
                                                @method('DELETE')
                                        @endif
                                            <button type="submit" class="btn btn-danger btn-sm" title="{{ __('admin-charge.delete_service_charge') }}" onclick="return confirm('Confirm delete?')">
                                                <i class="material-icons" aria-hidden="true">delete</i>
                                            </button>
                                        </form>
                                        
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $servicecharges->appends(['search' => Request::get('search')])->render() !!} </div>
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
