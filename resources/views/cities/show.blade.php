@extends('layouts.admin.master')

@section('title')

City {{ $city->id }}

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

                        <h4 class="card-title ">{{ __('admin-city.show_city') }} {{ $city->id }}</h4>

                        <a  href="{{ url('/cities') }}" class="btn btn-primary"> {{ __('admin-city.back') }}</a>

                    </div>

                    <div class="card-body">



                        <div class="table-responsive">

                            <table class="table table-bordered">

                                <tbody>

                                    <tr>

                                        <th>{{ __('admin-city.id') }}</th>

                                        <td>{{ $city->id }}</td>

                                    </tr>
                                    <tr>
                                        <th>{{ __('admin-city.state') }}</th>
                                        <td>
                                            @if($city->states)
                                                {{ $city->states->name }}
                                            @else
                                                {{ __('No state available') }}
                                            @endif
                                        </td>
                                    </tr>
                                    

                                    <tr>

                                        <th> {{ __('admin-city.name') }} </th>

                                        <td> {{ $city->name }} </td>

                                    </tr>

                                    <tr>

                                        <th> {{ __('admin-city.name_arabic') }} </th>

                                        <td> {{ $city->name_arabic }} </td>

                                    </tr>

                                    {{-- <tr>

                                        <th> Name Urdu </th>

                                        <td> {{ $city->name_urdu }} </td>

                                    </tr> --}}

                                    <tr>

                                        <th> {{ __('admin-city.description') }} </th>

                                        <td> {!! $city->description !!} </td>

                                    </tr>

                                    <tr>

                                        <th> {{ __('admin-city.description_arabic') }} </th>

                                        <td> {!! $city->description_arabic !!} </td>

                                    </tr>

                                    {{-- <tr>

                                        <th> Description Urdu </th>

                                        <td> {!! $city->description_urdu !!} </td>

                                    </tr> --}}

                                    @if($city->images != null)

                                        <tr>

                                            <th> {{ __('admin-city.image') }} </th>

                                            <td>

                                                @foreach($city->images as $image)

                                                <img src="{{ $image->url }}" alt="{{ $city->name }}" id="userImg" />

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

