@extends('layouts.admin.master')
@section('title')
Edit Product #{{ $product->id }}
@endsection
@section('admin-additional-css')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/css/select2.min.css">
<style type="text/css">
    .table-responsive>.table-bordered{
        border: 1;
    }
    #car_image{
        opacity: 1 !important;
        position: unset;
    }
    #carImg{
        width: 100px;
        height: 100px;
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
                        <h4 class="card-title ">{{ __('admin-product.edit_product') }} #{{ $product->id }}</h4>
                        <a  href="{{ url('/products') }}" class="btn btn-primary"> {{ __('admin-product.back') }}</a>
                    </div>
                    <div class="card-body">

                        @if(app()->getLocale() == 'ur')
                            {!! Form::model($product, [
                                'method' => 'POST',
                                'url' => ['/ur/products', $product->id],
                                'class' => 'form-horizontal',
                                'files' => true
                            ]) !!}
                        @elseif(app()->getLocale() == 'ar')
                            {!! Form::model($product, [
                                'method' => 'POST',
                                'url' => ['/ar/products', $product->id],
                                'class' => 'form-horizontal',
                                'files' => true
                            ]) !!}
                        @else
                            {!! Form::model($product, [
                                'method' => 'POST',
                                'url' => ['/products', $product->id],
                                'class' => 'form-horizontal',
                                'files' => true
                            ]) !!}
                        @endif

                        @include ('products.form', ['formMode' => 'edit'])

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('admin-additional-js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/js/select2.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
    });
</script>
@endsection
