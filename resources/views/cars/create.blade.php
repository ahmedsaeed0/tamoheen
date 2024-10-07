@extends('layouts.admin.master')

@section('title')

Create New Car

@endsection

@section('admin-additional-css')

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/css/select2.min.css">

<style type="text/css">
    .table-responsive>.table-bordered {

        border: 1;

    }

    #car_image {

        opacity: 1 !important;

        position: unset;

    }

    #carImg {

        width: 200px;

        height: 200px;

    }



    .tooltip-icon-mg {

        font-size: 20px;

    }



    .select2-results__options {

        text-align: start !important;

    }



    /* .hover_img a { position:relative; }

    .hover_img a span { position:absolute; display:none; z-index:99; }

    .hover_img a:hover span { display:block; } */
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

                        <h4 class="card-title ">{{ __('admin-car.create_new_car') }}</h4>

                        <a href="{{ url('/cars') }}" class="btn btn-primary"> {{ __('admin-car.back') }}</a>

                    </div>

                    <div class="card-body">

                        @if(app()->getLocale() == 'ur' || app()->getLocale() == 'ar')
                            {!! html()->form('POST', url('save_car'))->class('form-horizontal')->attribute('enctype', 'multipart/form-data')->open() !!}
                        @else
                            {!! html()->form('POST', url('save_car'))->class('form-horizontal')->attribute('enctype', 'multipart/form-data')->open() !!}
                        @endif
                    
                        @csrf
                    
                        @include('cars.form', ['formMode' => 'create'])
                    
                        {!! html()->closeModelForm() !!}
                    
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



    $(function() {

        $('[data-toggle="tooltip"]').tooltip()

    })
</script>

@endsection