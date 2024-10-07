@extends('layouts.admin.master')
@section('title')
Edit Country #{{ $country->id }}
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
                        <h4 class="card-title ">{{ __('admin-country.edit_country') }} #{{ $country->id }}</h4>
                        <a  href="{{ url('/countries') }}" class="btn btn-primary"> {{ __('admin-country.back') }}</a>
                    </div>
                    <div class="card-body">

                        @if(app()->getLocale() == 'ur')
                        <form method="POST" action="{{ url('/ur/countries', $country->id) }}" class="form-horizontal" enctype="multipart/form-data">
                    @elseif(app()->getLocale() == 'ar')
                        <form method="POST" action="{{ url('/ar/countries', $country->id) }}" class="form-horizontal" enctype="multipart/form-data">
                    @else
                        <form method="POST" action="{{ url('/countries', $country->id) }}" class="form-horizontal" enctype="multipart/form-data">
                    @endif
                        @csrf <!-- إضافة توكن CSRF لحماية النموذج -->
                        
                        @include ('countries.form', ['formMode' => 'edit'])
                    
                        
                    </form>
                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('admin-additional-js')
@endsection
