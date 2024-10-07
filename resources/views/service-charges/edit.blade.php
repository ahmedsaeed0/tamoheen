@extends('layouts.admin.master')
@section('title')
Edit ServiceCharge #{{ $servicecharge->id }}
@endsection
@section('admin-additional-css')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/css/select2.min.css">
@endsection
@section('content')
<div class="content">
    @include('layouts.admin.include.alert')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">{{ __('admin-charge.edit_service_charge') }} #{{ $servicecharge->id }}</h4>
                        <a  href="{{ url('/service-charges') }}" class="btn btn-primary"> {{ __('admin-charge.back') }}</a>
                    </div>
                    <div class="card-body">

                        @if(app()->getLocale() == 'ur')
                        <form method="POST" action="/ur/service-charges/{{ $servicecharge->id }}" class="form-horizontal" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                    @elseif(app()->getLocale() == 'ar')
                        <form method="POST" action="/ar/service-charges/{{ $servicecharge->id }}" class="form-horizontal" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                    @else
                        <form method="POST" action="/service-charges/{{ $servicecharge->id }}" class="form-horizontal" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                    @endif
                    
                    @include('service-charges.form', ['formMode' => 'edit'])
                    
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
<script type="text/javascript">
    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
    });
</script>
@endsection
