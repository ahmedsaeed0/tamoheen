@extends('layouts.admin.master')
@section('title')
Country {{ $country->id }}
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
                        <h4 class="card-title ">{{ __('admin-country.show_of_country') }} {{ $country->id }}</h4>
                        <a  href="{{ url('/countries') }}" class="btn btn-primary"> {{ __('admin-country.back') }}</a>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>{{ __('admin-country.id') }}</th>
                                        <td>{{ $country->id }}</td>
                                    </tr>
                                    <tr>
                                        <th> {{ __('admin-country.name') }} </th>
                                        <td> {{ $country->name }} </td>
                                    </tr>
                                    <tr>
                                        <th> {{ __('admin-country.name_arabic') }} </th>
                                        <td> {{ $country->name_arabic }} </td>
                                    </tr>
                                    {{-- <tr>
                                        <th> Name Urdu </th>
                                        <td> {{ $country->name_urdu }} </td>
                                    </tr> --}}
                                    <tr>
                                        <th> {{ __('admin-country.code') }} </th>
                                        <td> {{ $country->code }} </td>
                                    </tr>
                                    <tr>
                                        <th> {{ __('admin-country.code_arabic') }} </th>
                                        <td> {{ $country->code_arabic }} </td>
                                    </tr>
                                    {{-- <tr>
                                        <th> Code Urdu </th>
                                        <td> {{ $country->code_urdu }} </td>
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
