@extends('layouts.admin.master')
@section('title')
Create New ServiceCharge
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
                        <h4 class="card-title ">{{ __('admin-charge.create_new_service_charge') }}</h4>
                        <a  href="{{ url('/service-charges') }}" class="btn btn-primary"> {{ __('admin-charge.back') }}</a>
                    </div>
                    <div class="card-body">

                        @if(app()->getLocale() == 'ur')
                        <form method="POST" action="/ur/service-charges" class="form-horizontal" enctype="multipart/form-data">
                            @csrf
                    @elseif(app()->getLocale() == 'ar')
                        <form method="POST" action="/ar/service-charges" class="form-horizontal" enctype="multipart/form-data">
                            @csrf
                    @else
                        <form method="POST" action="/service-charges" class="form-horizontal" enctype="multipart/form-data">
                            @csrf
                    @endif
                    
                        @include('service-charges.form', ['formMode' => 'create'])
                    
                        
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
