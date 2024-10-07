@extends('layouts.admin.master')
@section('title')
ProductType {{ $producttype->id }}
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
                        <h4 class="card-title ">{{ __('admin-product-type.show_product_type') }} {{ $producttype->id }}</h4>
                        <a  href="{{ url('/product-types') }}" class="btn btn-primary"> {{ __('admin-product-type.back') }}</a>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>{{ __('admin-product-type.id') }}</th>
                                        <td>{{ $producttype->id }}</td>
                                    </tr>
                                    <tr>
                                        <th> {{ __('admin-product-type.name') }} </th>
                                        <td> {{ $producttype->name }} </td>
                                    </tr>
                                    <tr>
                                        <th> {{ __('admin-product-type.name_arabic') }} </th>
                                        <td> {{ $producttype->name_arabic }} </td>
                                    </tr>
                                    {{-- <tr>
                                        <th> Name Urdu </th>
                                        <td> {{ $producttype->name_urdu }} </td>
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
