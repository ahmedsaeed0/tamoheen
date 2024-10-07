@extends('layouts.admin.master')
@section('title')
Edit Car # {{ $car->id }}
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

    .tooltip-icon-mg{
        font-size: 20px;
    }
    
    .select2-results__options{
        text-align: start !important;
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
                        <h4 class="card-title ">{{ __('admin-car.edit_car') }} # {{ $car->id }}</h4>
                        <a  href="{{ url('/cars') }}" class="btn btn-primary"> {{ __('admin-car.back') }}</a>
                    </div>
                    <div class="card-body">
                        @if(app()->getLocale() == 'ur')
                            {!! html()->form('POST', url('/ur/cars', $car->id), [
                                'class' => 'form-horizontal',
                                'files' => true
                            ])->open() !!}
                        @elseif(app()->getLocale() == 'ar')
                            {!! html()->form('POST', url('/ar/cars', $car->id), [
                                'class' => 'form-horizontal',
                                'files' => true
                            ])->open() !!}
                        @else
                            {!! html()->form('POST', url('/cars', $car->id), [
                                'class' => 'form-horizontal',
                                'files' => true
                            ])->open() !!}
                        @endif
                    
                        @include('cars.form', ['formMode' => 'edit'])
                    
                        {{-- إغلاق النموذج --}}
                        {!! html()->form()->close() !!}
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
