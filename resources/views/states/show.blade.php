@extends('layouts.admin.master')
@section('title')
State {{ $state->id }}
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
                        <h4 class="card-title ">{{ __('admin-state.show_state') }} {{ $state->id }}</h4>
                        <a  href="{{ url('/states') }}" class="btn btn-primary"> {{ __('admin-state.back') }}</a>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>{{ __('admin-state.id') }}</th>
                                        <td>{{ $state->id }}</td>
                                    </tr>
                                    <tr>
                                        <th> {{ __('admin-state.country') }} </th>
                                        <td> {{ $state->countries->name }} </td>
                                    </tr>
                                    <tr>
                                        <th> {{ __('admin-state.name') }} </th>
                                        <td> {{ $state->name }} </td>
                                    </tr>
                                    <tr>
                                        <th> {{ __('admin-state.name_arabic') }} </th>
                                        <td> {{ $state->name_arabic }} </td>
                                    </tr>
                                    {{-- <tr>
                                        <th> Name Urdu </th>
                                        <td> {{ $state->name_urdu }} </td>
                                    </tr> --}}
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
