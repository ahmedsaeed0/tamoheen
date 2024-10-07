@extends('layouts.admin.master')
@section('title')
Create New ProductType
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
                        <h4 class="card-title ">{{ __('admin-product-type.create_new_product_type') }}</h4>
                        <a  href="{{ url('/product-types') }}" class="btn btn-primary"> {{ __('admin-product-type.back') }}</a>
                    </div>
                    <div class="card-body">

                        <form method="POST" action="{{ app()->getLocale() == 'ur' ? url('/ur/product-types') : (app()->getLocale() == 'ar' ? url('/ar/product-types') : url('/product-types')) }}" class="form-horizontal" enctype="multipart/form-data">
                            @csrf
                        
                            @include('product-types.form', ['formMode' => 'create'])
                        
                            {{-- <button type="submit" class="btn btn-primary">Submit</button> --}}
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
