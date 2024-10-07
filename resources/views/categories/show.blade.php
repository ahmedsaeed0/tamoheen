@extends('layouts.admin.master')
@section('title')
Category {{ $category->id }}
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
                        <h4 class="card-title ">{{ __('admin-category.show_category') }} {{ $category->id }}</h4>
                        <a  href="{{ url('/categories') }}" class="btn btn-primary"> {{ __('admin-category.back') }}</a>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>{{ __('admin-category.id') }}</th>
                                        <td>{{ $category->id }}</td>
                                    </tr>
                                    <tr>
                                        <th> {{ __('admin-category.name') }} </th>
                                        <td> {{ $category->name }} </td>
                                    </tr>
                                    <tr>
                                        <th> {{ __('admin-category.name_arabic') }} </th>
                                        <td> {{ $category->name_arabic }} </td>
                                    </tr>
                                    {{-- <tr>
                                        <th> Name Urdu </th>
                                        <td> {{ $category->name_urdu }} </td>
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
