@extends('layouts.admin.master')
@section('title')
Create New Slider
@endsection
@section('admin-additional-css')
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
                        <h4 class="card-title ">{{ __('admin-sliders.create_new_slider') }}</h4>
                        <a  href="{{ url('/sliders') }}" class="btn btn-primary"> {{ __('admin-sliders.back') }}</a>
                    </div>
                    <div class="card-body">

                        @if(app()->getLocale() == 'ur')
                        {!! Html::form('POST', url('/ur/sliders'))->class('form-horizontal')->attribute('enctype', 'multipart/form-data')->open() !!}
                        @elseif(app()->getLocale() == 'ar')
                        {!! Html::form('POST', url('/ar/sliders'))->class('form-horizontal')->attribute('enctype', 'multipart/form-data')->open() !!}

                        @else
                        {!! html()->form('DELETE', url('/sliders', $item->id))->style('display:inline')->open() !!}
                        @endif

                        @include ('sliders.form', ['formMode' => 'create'])

                        {!! Html::form()->close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('admin-additional-js')
@endsection
