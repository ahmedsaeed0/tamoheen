@extends('layouts.admin.master')
@section('title')
Product {{ $product->id }}
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
                        <h4 class="card-title ">{{ __('admin-product.show_product') }} {{ $product->id }}</h4>
                        <a  href="{{ url('/products') }}" class="btn btn-primary"> {{ __('admin-product.back') }}</a>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>{{ __('admin-product.id') }}</th>
                                        <td>{{ $product->id }}</td>
                                    </tr>
                                    <tr>
                                        <th> {{ __('admin-product.category') }} </th>
                                        <td> {{ $product->categories->name }} </td>
                                    </tr>
                                    <tr>
                                        <th> {{ __('admin-product.name') }} </th>
                                        <td> {{ $product->name }} </td>
                                    </tr>
                                    <tr>
                                        <th> {{ __('admin-product.name_arabic') }} </th>
                                        <td> {{ $product->name_arabic }} </td>
                                    </tr>
                                    {{-- <tr>
                                        <th> Name Urdu </th>
                                        <td> {{ $product->name_urdu }} </td>
                                    </tr> --}}
                                    <tr>
                                        <th> {{ __('admin-product.description') }} </th>
                                        <td> {{ $product->description }} </td>
                                    </tr>
                                    <tr>
                                        <th> {{ __('admin-product.description_arabic') }} </th>
                                        <td> {{ $product->description_arabic }} </td>
                                    </tr>
                                    {{-- <tr>
                                        <th> Description Urdu </th>
                                        <td> {{ $product->description_urdu }} </td>
                                    </tr> --}}
                                    <tr>
                                        <th> {{ __('admin-product.price') }} </th>
                                        <td> {{ $product->price }} </td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('admin-product.status') }}</th>
                                        <td>
                                            @if($product->status == 1)
                                                <span class="badge badge-success">{{ __('admin-product.active') }}</span>
                                            @else
                                                <span class="badge badge-danger">{{ __('admin-product.deactive') }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @if($product->image != null)
                                    <tr>
                                        <th> {{ __('admin-product.image') }} </th>
                                        <td>
                                            <img src="{{ asset('storage/'.$product->image->url) }}" alt="{{ $product->name }}" id="userImg" />
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
