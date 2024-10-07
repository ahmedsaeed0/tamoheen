@extends('layouts.admin.master')
@section('title')
Edit Category #{{ $category->id }}
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
                        <h4 class="card-title ">{{ __('admin-category.edit_category') }} #{{ $category->id }}</h4>
                        <a  href="{{ url('/categories') }}" class="btn btn-primary"> {{ __('admin-category.back') }}</a>
                    </div>
                    <div class="card-body">
                        @if(app()->getLocale() == 'ur')
                            {!! Form::model($category, [
                                'method' => 'POST',
                                'url' => ['/ur/categories', $category->id],
                                'class' => 'form-horizontal',
                                'files' => true
                            ]) !!}
                        @elseif(app()->getLocale() == 'ar')
                            {!! Form::model($category, [
                                'method' => 'POST',
                                'url' => ['/ar/categories', $category->id],
                                'class' => 'form-horizontal',
                                'files' => true
                            ]) !!}
                        @else
                            {!! Form::model($category, [
                                'method' => 'POST',
                                'url' => ['/categories', $category->id],
                                'class' => 'form-horizontal',
                                'files' => true
                            ]) !!}
                        @endif

                        @include ('categories.form', ['formMode' => 'edit'])

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('admin-additional-js')
@endsection
