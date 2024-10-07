@extends('layouts.admin.master')
@section('title')
Create New Admin
@endsection
@section('admin-additional-css')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/css/select2.min.css">
<style type="text/css">
    #user_image{
        opacity: 1 !important;
        position: unset;
    }
    #userImg{
        width: 200px;
        height: 200px;
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
                        <h4 class="card-title ">@lang('admin-users.create_new_admin')</h4>
                        <a  href="{{ url('/admins') }}" class="btn btn-primary"> @lang('admin-users.back')</a>
                    </div>
                    <div class="card-body">

                        @if(app()->getLocale() == 'ur')
                        {!! html()->form('POST', '/ur/admins', ['class' => 'form-horizontal', 'files' => true])->open() !!}
                    @elseif(app()->getLocale() == 'ar')
                        {!! html()->form('POST', '/ar/admins', ['class' => 'form-horizontal', 'files' => true])->open() !!}
                    @else
                        {!! html()->form('POST', '/admins', ['class' => 'form-horizontal', 'files' => true])->open() !!}
                    @endif
                    
                    @include('admins.form', ['formMode' => 'create'])
                    
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
