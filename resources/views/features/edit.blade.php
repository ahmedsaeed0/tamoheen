@extends('layouts.admin.master')
@section('title')
Edit Feature #{{ $feature->id }}
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
                        <h4 class="card-title ">{{ __('admin-feature.edit_feature') }} #{{ $feature->id }}</h4>
                        <a  href="{{ url('/features') }}" class="btn btn-primary"> {{ __('admin-feature.back') }}</a>
                    </div>
                    <div class="card-body">

                        @if(app()->getLocale() == 'ur')
                            <form method="POST" action="/ur/features/{{ $feature->id }}" class="form-horizontal" enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                        @elseif(app()->getLocale() == 'ar')
                            <form method="POST" action="/ar/features/{{ $feature->id }}" class="form-horizontal" enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                        @else
                            <form method="POST" action="/features/{{ $feature->id }}" class="form-horizontal" enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                        @endif

                        @include ('features.form', ['formMode' => 'edit'])

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
