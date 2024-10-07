@extends('layouts.admin.master')
@section('title')
Create New Page
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
                        <h4 class="card-title ">@lang('admin-pages.create_new_page')</h4>
                        <a  href="{{ url('/pages') }}" class="btn btn-primary"> @lang('admin-pages.back')</a>
                    </div>
                    <div class="card-body">
                        <?php
                        // تحديد رابط الـ URL بناءً على اللغة الحالية
                        if (app()->getLocale() == 'ur') {
                            $formUrl = '/ur/pages';
                        } elseif (app()->getLocale() == 'ar') {
                            $formUrl = '/ar/pages';
                        } else {
                            $formUrl = '/pages';
                        }
                    ?>
                    
                    <form action="{{ $formUrl }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
                        <!-- محتويات النموذج -->
                        @csrf
                        @include('pages.form', ['formMode' => 'create'])
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
