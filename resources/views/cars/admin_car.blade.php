@extends('layouts.admin.master')

@section('title')

Cars

@endsection

@section('admin-additional-css')

<style type="text/css">

    .table-responsive>.table-bordered{

        border: 1;

    }

</style>

@endsection

@section('content')

<div class="content">

    @include('layouts.admin.include.alert')

    <div class="container-fluid">

        <div class="row">

            <div class="col-md-12">

                <div class="card">

                    <div class="card-header card-header-primary">

                        <h4 class="card-title ">{{ __('admin-car.car_list') }}</h4>

                        <!-- <a  href="{{ url('/cars/create') }}" class="btn btn-primary"> {{ __('admin-car.add_new_car') }}</a> -->

                    </div>
                    <div class="card-body">

                        <div class="table-responsive">

                            <table class="table table-bordered">

                                <thead class="text-primary">
                                    <th>{{ __('admin-car.model') }}</th>
                                    <th>{{ __('admin-car.actions') }}</th>
                                </thead>
                                <tbody>
                                    @foreach($cars as $item)
                                    <tr>
                                        <td>{{ $item->name }}</td>
                                        <td>
                                            <a href="{{ url('adminCars/'.$item->id) }}" title="{{ __('admin-car.view_car') }}" class="btn btn-info btn-sm">
                                                <i class="material-icons">
                                                    remove_red_eye

                                                </i>

                                            </a>

                

                                        </td>

                                    </tr>

                                    @endforeach

                                </tbody>

                            </table>

                            <div class="pagination-wrapper"> {!! $cars->appends(['search' => Request::get('search')])->render() !!} </div>

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