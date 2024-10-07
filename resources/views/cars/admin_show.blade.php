@extends('layouts.admin.master')

@section('title')

Car {{ $car->id }}

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

                        <h4 class="card-title ">{{ __('admin-car.show_car') }} {{ $car->id }}</h4>

                        <a  href="{{ url('adminCars') }}" class="btn btn-primary"> {{ __('admin-car.back') }}</a>

                    </div>

                    <div class="card-body">



                        <div class="table-responsive">

                            <table class="table table-bordered">

                                <tbody>

                                    <tr>

                                        <th>{{ __('admin-car.id') }}</th>

                                        <td>{{ $car->id }}</td>

                                    </tr>

                                    <tr>

                                        <th> {{ __('admin-car.model') }} </th>

                                        <td> {{ $car->name }} </td>

                                    </tr>

                                    <tr>

                                        <th> {{ __('admin-car.name_arabic') }} </th>

                                        <td> {{ $car->name_arabic }} </td>

                                    </tr>

                                    {{-- <tr>

                                        <th> Name Urdu </th>

                                        <td> {{ $car->name_urdu }} </td>

                                    </tr> --}}

                                    <tr>

                                        <th> {{ __('admin-car.capacity_of_person') }} </th>

                                        <td> {{ $car->capacity_of_person }} </td>

                                    </tr>

                                    <tr>

                                        <th> {{ __('admin-car.capacity_of_bag') }} </th>

                                        <td> {{ $car->capacity_of_bag }} </td>

                                    </tr>

                                    @if($car->images != null)

                                    <tr>

                                        <th> {{ __('admin-car.image') }} </th>

                                        <td>

                                            @foreach($car->images as $image)

                                            <img src="{{ $image->url }}" alt="{{ $car->name }}" id="userImg" />

                                            @endforeach

                                        </td>

                                    </tr>

                                    @endif



                                    @if($car->carFeatures != null)



                                        <tr>

                                            <th> {{ __('admin-car.feature') }} </th>

                                            <td>

                                                @foreach($car->carFeatures as $feature)

                                                    <span class="badge badge-success">{{ $feature->name }}</span>

                                                @endforeach

                                            </td>

                                        </tr>

                                    @endif

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

