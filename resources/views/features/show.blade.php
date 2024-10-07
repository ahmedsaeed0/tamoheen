@extends('layouts.admin.master')

@section('title')

Feature {{ $feature->id }}

@endsection

@section('admin-additional-css')

<style type="text/css">

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

                        <h4 class="card-title ">{{ __('admin-feature.show_feature') }} {{ $feature->id }}</h4>

                        <a  href="{{ url('/features') }}" class="btn btn-primary"> {{ __('admin-feature.back') }}</a>

                    </div>

                    <div class="card-body">



                        <div class="table-responsive">

                            <table class="table table-bordered">

                                <tbody>

                                    <tr>

                                        <th>{{ __('admin-feature.id') }}</th>

                                        <td>{{ $feature->id }}</td>

                                    </tr>

                                    <tr>

                                        <th> {{ __('admin-feature.name') }} </th>

                                        <td> {{ $feature->name }} </td>

                                    </tr>

                                    <tr>

                                        <th> {{ __('admin-feature.name_arabic') }} </th>

                                        <td> {{ $feature->name_arabic }} </td>

                                    </tr>

                                    {{-- <tr>

                                        <th> Name Urdu </th>

                                        <td> {{ $feature->name_urdu }} </td>

                                    </tr> --}}

                                    <tr>

                                        <th>{{ __('admin-feature.is_main') }}</th>

                                        <td>

                                            @if($feature->is_main == 1)

                                                <span class="badge badge-success">{{ __('admin-feature.yes') }}</span>

                                            @else

                                                <span class="badge badge-danger">{{ __('admin-feature.no') }}</span>

                                            @endif

                                        </td>

                                    </tr>

                                    <tr>

                                        <th>{{ __('admin-feature.note') }}</th>

                                        <td>{{ $feature->note }}</td>

                                    </tr>

                                    <tr>

                                        <th> {{ __('admin-feature.icon') }} </th>

                                        <td>

                                            @if($feature->image != null)

                                            <img src="{{ $feature->image->url }}" alt="{{ $feature->name }}" id="userImg" />

                                            @else

                                                <span class="badge badge-danger">{{ __('admin-feature.no_image') }}</span>

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

    </div>

</div>

@endsection

@section('admin-additional-js')



@endsection

