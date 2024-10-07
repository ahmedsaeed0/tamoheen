@extends('layouts.admin.master')
@section('title')
Edit State #{{ $state->id }}
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
                        <h4 class="card-title ">{{ __('admin-state.edit_state') }} #{{ $state->id }}</h4>
                        <a  href="{{ url('/states') }}" class="btn btn-primary"> {{ __('admin-state.back') }}</a>
                    </div>
                    <div class="card-body">

                        @if(app()->getLocale() == 'ur')
                        <form method="POST" action="{{ url('/ur/states', $state->id) }}" class="form-horizontal" enctype="multipart/form-data">
                    @elseif(app()->getLocale() == 'ar')
                        <form method="POST" action="{{ url('/ar/states', $state->id) }}" class="form-horizontal" enctype="multipart/form-data">
                    @else
                        <form method="POST" action="{{ url('/states', $state->id) }}" class="form-horizontal" enctype="multipart/form-data">
                    @endif
                        @csrf <!-- إضافة توكن CSRF -->
                        
                        @method('POST') <!-- تحديد طريقة POST -->
                    
                        @include('states.form', ['formMode' => 'edit'])
                    
                      
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
