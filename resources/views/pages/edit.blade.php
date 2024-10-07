@extends('layouts.admin.master')
@section('title')
Edit Page #{{ $page->id }}
@endsection
@section('admin-additional-css')
@endsection
@section('content')
<div class="content">
    @include('layouts.admin.include.alert')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">@lang('admin-pages.edit_page') #{{ $page->id }}</h4>
                        <a  href="{{ url('/pages') }}" class="btn btn-primary"> @lang('admin-pages.back')</a>
                    </div>
                    <div class="card-body">

                        @if(app()->getLocale() == 'ur')
                        <form method="POST" action="/ur/pages/{{ $page->id }}" class="form-horizontal" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                    @elseif(app()->getLocale() == 'ar')
                        <form method="POST" action="/ar/pages/{{ $page->id }}" class="form-horizontal" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                    @else
                        <form method="POST" action="/pages/{{ $page->id }}" class="form-horizontal" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                    @endif
                    
                        @include('pages.form', ['formMode' => 'edit'])
                    
                        
                    </form>
                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('admin-additional-js')
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script type="text/javascript">
    
</script>
@endsection
