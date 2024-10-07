@extends('layouts.admin.master')
@section('title')
Create New Country
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
                        <h4 class="card-title ">{{ __('admin-country.create_new_country') }}</h4>
                        <a  href="{{ url('/countries') }}" class="btn btn-primary"> {{ __('admin-country.back') }}</a>
                    </div>
                    <div class="card-body">

                        @if(app()->getLocale() == 'ur')
                            {!! Html::form('POST', url('/ur/countries'), ['class' => 'form-horizontal', 'files' => true])->open() !!}
                        @elseif(app()->getLocale() == 'ar')
                            {!! Html::form('POST', url('/ar/countries'), ['class' => 'form-horizontal', 'files' => true])->open() !!}
                        @else
                            {!! Html::form('POST', url('/countries'), ['class' => 'form-horizontal', 'files' => true])->open() !!}
                        @endif

                        @include('countries.form', ['formMode' => 'create'])

                        {!! Html::form()->close() !!}


                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('admin-additional-js')
@endsection
