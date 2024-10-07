@extends('layouts.admin.master')
@section('title')
Edit Slider #{{ $slider->id }}
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
                        <h4 class="card-title ">{{ __('admin-sliders.edit_slider') }} #{{ $slider->id }}</h4>
                        <a  href="{{ url('/sliders') }}" class="btn btn-primary"> {{ __('admin-sliders.back') }}</a>
                    </div>
                    <div class="card-body">

                        @if(app()->getLocale() == 'ur')
                        {!! Html::modelForm($slider, 'PATCH', url('/ur/sliders/' . $slider->id))
                            ->class('form-horizontal')
                            ->attribute('enctype', 'multipart/form-data')
                            ->open() !!}
                        @elseif(app()->getLocale() == 'ar')
                        {!! Html::modelForm($slider, 'PATCH', url('/ar/sliders/' . $slider->id))
                            ->class('form-horizontal')
                            ->attribute('enctype', 'multipart/form-data')
                            ->open() !!}
                        @else
                        {!! Html::modelForm($slider, 'PATCH', url('/sliders/' . $slider->id))
                            ->class('form-horizontal')
                            ->attribute('enctype', 'multipart/form-data')
                            ->open() !!}
                        @endif

                        @include ('sliders.form', ['formMode' => 'edit'])

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
