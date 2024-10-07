@extends('layouts.admin.master')
@section('title')
Complains
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
                    <div class="card-header card-header-primary d-flex justify-content-between align-items-center">
                        <h4 class="card-title ">{{ __('admin-complain.complains') }}</h4>
                        <a href="{{url('/export-excel/complains')}}"><button class="btn btn-success btn-sm" data-target="trip">Export<div class="ripple-container"></div></button></a>
                    </div>
                    <div class="card-body">
                        @foreach($complains as $item)
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p> {{__('admin-complain.date') }} : {{ $item->created_at?? '' }}</p>
                                            <p> {{__('admin-complain.trip') }} : {{ $item->trip->title ?? '' }}</p>
                                        </div>
                                        <div class="col-md-4">
                                            <p> {{__('admin-complain.complain_from') }} : {{ $item->complainsFrom->name }}</p>
                                            @role('admin')
                                                <p> {{__('admin-complain.complain_to') }} : {{ $item->complainsTo->name }}</p>
                                            @endrole
                                        </div>
                                        <div class="col-md-4">
                                            <p>{{ __('admin-complain.complain_title') }} : {{ $item->title }}</p>
                                            <p>{{ __('admin-complain.description') }} : {{ $item->description }}</p>
                                        </div>
                                        <div class="col-md-12">
                                            @role('admin')
                                            @if(app()->getLocale() == 'ur')
                                            <form method="POST" action="{{ url('/ar/complains/' . $item->id) }}" style="display:inline">
                                        @elseif(app()->getLocale() == 'ar')
                                            <form method="POST" action="{{ url('/ar/complains/' . $item->id) }}" style="display:inline">
                                        @else
                                            <form method="POST" action="{{ url('/complains/' . $item->id) }}" style="display:inline">
                                        @endif
                                        @csrf
                                        @method('DELETE')
                                        
                                        <button type="submit" class="btn btn-danger btn-sm" title="{{ __('admin-complain.delete_complain') }}" onclick="return confirm('Confirm delete?')">
                                            <i class="material-icons" aria-hidden="true">delete</i>
                                        </button>
                                    </form>
                                                {{-- {!! Form::close() !!} --}}
                                            @endrole
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
