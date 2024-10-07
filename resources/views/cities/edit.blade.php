@extends('layouts.admin.master')
@section('title')
Edit City #{{ $city->id }}
@endsection
@section('admin-additional-css')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/css/select2.min.css">
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
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
                        <h4 class="card-title ">{{ __('admin-city.edit_city') }} #{{ $city->id }}</h4>
                        <a  href="{{ url('/cities') }}" class="btn btn-primary"> {{ __('admin-city.back') }}</a>
                    </div>
                    <div class="card-body">
                        <form action="{{ app()->getLocale() == 'ur' ? '/ur/cities/' . $city->id : (app()->getLocale() == 'ar' ? '/ar/cities/' . $city->id : '/cities/' . $city->id) }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                        
                            @include('cities.form', ['formMode' => 'edit'])
                        
                            {{-- <button type="submit" class="btn btn-primary">{{ ('admin-cities.update') }}</button>    --}}
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('admin-additional-js')
{{-- <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script> --}}
<script src="https://cdn.tiny.cloud/1/rj8125r922hr08e3c7nzrmdlr6fhukzj0wbjgv32gnm5mtjc/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/js/select2.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
    });
    tinymce.init({
        selector: '#mytextarea'
      });
</script>
@endsection
