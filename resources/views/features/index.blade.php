@extends('layouts.admin.master')

@section('title')

Features

@endsection

@section('admin-additional-css')

<style type="text/css">

    #userImg{

        width: 50px;

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

                    <div class="card-header card-header-primary d-flex justify-content-between align-items-center">

                        <div>

                            <h4 class="card-title ">{{ __('admin-feature.features') }}</h4>

                            <a  href="{{ url('/features/create') }}" class="btn btn-primary"> {{ __('admin-feature.add_new_feature') }}</a>

                        </div>

                        <div><a href="{{url('/export-excel/features')}}"><button class="btn btn-success btn-sm" data-target="trip">Export<div class="ripple-container"></div></button></a></div>

                        

                    </div>

                    <div class="card-body">

                        @foreach($features as $item)

                        <div class="card">

                            <div class="card-body">

                                <div class="row">

                                    <div class="col-md-6">

                                        <p>{{ __('admin-feature.icon') }} : 

                                            @if($item->image != null)

                                                <img src="{{ $item->image->url }}" alt="{{ $item->name }}" id="userImg" />

                                            @else

                                                <span class="badge badge-danger">{{ __('admin-feature.no_image') }}</span>

                                            @endif

                                        </p>

                                        <p>{{ __('admin-feature.name') }} : {{ $item->name }}</p>

                                        <p>{{ __('admin-feature.name_arabic') }} : {{ $item->name_arabic }}</p>

                                    </div>

                                    <div class="col-md-6">

                                        {{-- <p>Name Urdu : { $item->name_urdu }}</p> --}}

                                        <p>{{ __('admin-feature.is_main') }}:

                                            @if($item->is_main == 1)

                                                <span class="badge badge-success">{{ __('admin-feature.yes') }}</span>

                                            @else

                                                <span class="badge badge-danger">{{ __('admin-feature.no') }}</span>

                                            @endif

                                        </p>                                        

                                    </div>

                                    <div class="col-md-12">

                                        <a href="{{ url('/features/' . $item->id) }}" title="{{ __('admin-feature.view_feature') }}" class="btn btn-info btn-sm">

                                            <i class="material-icons">

                                                remove_red_eye

                                            </i>

                                        </a>



                                        <a href="{{ url('/features/' . $item->id . '/edit') }}" title="{{ __('admin-feature.edit_feature') }}" class="btn btn-success btn-sm">

                                            <i class="material-icons">

                                                edit

                                            </i>

                                        </a>

                                        @if(app()->getLocale() == 'ur')
                                                <form method="POST" action="{{ url('/ur/features', $item->id) }}" style="display:inline">
                                                    @csrf
                                                    @method('DELETE')
                                            @elseif(app()->getLocale() == 'ar')
                                                <form method="POST" action="{{ url('/ar/features', $item->id) }}" style="display:inline">
                                                    @csrf
                                                    @method('DELETE')
                                            @else
                                                <form method="POST" action="{{ url('/features', $item->id) }}" style="display:inline">
                                                    @csrf
                                                    @method('DELETE')
                                            @endif

                                                    <button type="submit" class="btn btn-danger btn-sm" title="{{ __('admin-feature.delete_feature') }}" onclick="return confirm('Confirm delete?')">
                                                        <i class="material-icons" aria-hidden="true">delete</i>
                                                    </button>
                                                </form>


                                    </div>

                                </div>

                            </div>

                        </div>

                        @endforeach

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection

@section('admin-additional-js')



@endsection

