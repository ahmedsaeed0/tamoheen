@extends('layouts.admin.master')
@section('title')
Edit Term #{{ $term->id }}
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
                        <h4 class="card-title ">Edit Term #{{ $term->id }}</h4>
                        <a  href="{{ url('/terms') }}" class="btn btn-primary"> Back</a>
                    </div>
                    <div class="card-body">

                        @if(app()->getLocale() == 'ur')
                            {!! Form::model($term, [
                                'method' => 'POST',
                                'url' => ['/ur/terms', $term->id],
                                'class' => 'form-horizontal',
                                'files' => true
                            ]) !!}
                        @elseif(app()->getLocale() == 'ar')
                            {!! Form::model($term, [
                                'method' => 'POST',
                                'url' => ['/ar/terms', $term->id],
                                'class' => 'form-horizontal',
                                'files' => true
                            ]) !!}
                        @else
                            {!! Form::model($term, [
                                'method' => 'POST',
                                'url' => ['/terms', $term->id],
                                'class' => 'form-horizontal',
                                'files' => true
                            ]) !!}
                        @endif

                        @include ('terms.form', ['formMode' => 'edit'])

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
