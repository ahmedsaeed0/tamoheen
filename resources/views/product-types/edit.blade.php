@extends('layouts.admin.master')
@section('title')
Edit ProductType #{{ $producttype->id }}
@endsection
@section('admin-additional-css')
@endsection
@section('content')
<div class="content">
    @include('layouts.admin.include.alert')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">{{ __('admin-product-type.edit_product_type') }} #{{ $producttype->id }}</h4>
                        <a  href="{{ url('/product-types') }}" class="btn btn-primary"> {{ __('admin-product-type.back') }}</a>
                    </div>
                    <div class="card-body">

                        <form method="POST" action="{{ app()->getLocale() == 'ur' ? url('/ur/product-types/' . $producttype->id) : (app()->getLocale() == 'ar' ? url('/ar/product-types/' . $producttype->id) : url('/product-types/' . $producttype->id)) }}" class="form-horizontal" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                        
                            @include('product-types.form', ['formMode' => 'edit'])
                        
                            
                        </form>
                        



                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('admin-additional-js')
@endsection
