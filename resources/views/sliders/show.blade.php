@extends('layouts.admin.master')

@section('title')

Slider {{ $slider->id }}

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

                        <h4 class="card-title ">{{ __('admin-sliders.slider') }} {{ $slider->id }}</h4>

                        <a  href="{{ url('/sliders') }}" class="btn btn-primary"> {{ __('admin-sliders.back') }}</a>

                    </div>

                    <div class="card-body">



                        <div class="table-responsive">

                            <table class="table table-bordered">

                                <tbody>

                                    <tr>

                                        <th>{{ __('admin-sliders.id') }}</th>

                                        <td>{{ $slider->id }}</td>

                                    </tr>

                                    <tr>

                                        <th> {{ __('admin-sliders.title') }} </th>

                                        <td> {{ $slider->title }} </td>

                                    </tr>

                                    {{-- <tr>

                                        <th> Title Urdu </th>

                                        <td> {{ $slider->title_urdu }} </td>

                                    </tr> --}}

                                    <tr>

                                        <th> {{ __('admin-sliders.title_arabic') }} </th>

                                        <td> {{ $slider->title_arabic }} </td>

                                    </tr>

                                    <tr>

                                        <th> {{ __('admin-sliders.description') }} </th>

                                        <td> {{ $slider->description }} </td>

                                    </tr>

                                    {{-- <tr>

                                        <th> Description Urdu </th>

                                        <td> {{ $slider->description_urdu }} </td>

                                    </tr> --}}

                                    <tr>

                                        <th> {{ __('admin-sliders.description_arabic') }} </th>

                                        <td> {{ $slider->description_arabic }} </td>

                                    </tr>

                                    @if($slider->image != null)

                                    <tr>

                                        <th> {{ __('admin-sliders.image') }} </th>

                                        <td>

                                            <img src="{{ $slider->image->url }}" src="" style="width: 100px; height: 100px;">

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

