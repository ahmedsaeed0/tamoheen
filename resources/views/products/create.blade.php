@extends('layouts.admin.master')

@section('title')

Create New Product

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

        width: 200px;

        height: 200px;

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

                        <h4 class="card-title ">{{ __('admin-product.create_new_product') }}</h4>

                        <a  href="{{ url('/products') }}" class="btn btn-primary"> {{ __('admin-product.back') }}</a>

                    </div>

                    <div class="card-body">



                        @if(app()->getLocale() == 'ur')

                            {!! Form::open(['url' => '/ur/products', 'class' => 'form-horizontal', 'files' => true]) !!}

                        @elseif(app()->getLocale() == 'ar')

                            {!! Form::open(['url' => '/ar/products', 'class' => 'form-horizontal', 'files' => true]) !!}

                        @else

                            {!! Form::open(['url' => '/products', 'class' => 'form-horizontal', 'files' => true]) !!}

                        @endif



                        @include ('products.form', ['formMode' => 'create'])



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

