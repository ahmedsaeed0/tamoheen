@extends('layouts.admin.master')
@section('title')
Create New Term
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
                        <h4 class="card-title ">Create New Term</h4>
                        <a  href="{{ url('/terms') }}" class="btn btn-primary"> Back</a>
                    </div>
                    <div class="card-body">

                        @if(app()->getLocale() == 'ur')
                            {!! Form::open(['url' => '/ur/terms', 'class' => 'form-horizontal', 'files' => true]) !!}
                        @elseif(app()->getLocale() == 'ar')
                            {!! Form::open(['url' => '/ar/terms', 'class' => 'form-horizontal', 'files' => true]) !!}
                        @else
                            {!! Form::open(['url' => '/terms', 'class' => 'form-horizontal', 'files' => true]) !!}
                        @endif

                        @include ('terms.form', ['formMode' => 'create'])

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
