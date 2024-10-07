@extends('layouts.admin.master')
@section('title')
Create New State
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
                        <h4 class="card-title ">{{ __('admin-state.create_new_state') }}</h4>
                        <a  href="{{ url('/states') }}" class="btn btn-primary"> {{ __('admin-state.back') }}</a>
                    </div>
                    <div class="card-body">

                        <form action="{{ app()->getLocale() == 'ur' ? '/ur/states' : (app()->getLocale() == 'ar' ? '/ar/states' : '/states') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                            @csrf
                        
                            @include('states.form', ['formMode' => 'create'])
                        
                            {{-- <button type="submit" class="btn btn-primary">{{ __('admin-states.create') }}</button> --}}
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
