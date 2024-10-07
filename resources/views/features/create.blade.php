@extends('layouts.admin.master')
@section('title')
Create New Feature
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
                        <h4 class="card-title ">{{ __('admin-feature.create_new_feature') }}</h4>
                        <a  href="{{ url('/features') }}" class="btn btn-primary"> {{ __('admin-feature.back') }}</a>
                    </div>
                    <div class="card-body">

                        @if(app()->getLocale() == 'ur')
                            <form method="POST" action="{{ url('/ur/features') }}" class="form-horizontal" enctype="multipart/form-data">
                        @elseif(app()->getLocale() == 'ar')
                            <form method="POST" action="{{ url('/ar/features') }}" class="form-horizontal" enctype="multipart/form-data">
                        @else
                            <form method="POST" action="{{ url('/features') }}" class="form-horizontal" enctype="multipart/form-data">
                        @endif

                            @csrf

                            @include('features.form', ['formMode' => 'create'])

                            
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('admin-additional-js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
    });
</script>
@endsection
