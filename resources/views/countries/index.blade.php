@extends('layouts.admin.master')
@section('title')
Countries
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
                        <div>
                            <h4 class="card-title ">{{ __('admin-country.countries') }}</h4>
                            <a  href="{{ url('/countries/create') }}" class="btn btn-primary"> {{ __('admin-country.add_new_country') }}</a>
                        </div>
                        <div>
                            <a href="{{url('/export-excel/countries')}}"><button class="btn btn-success btn-sm" data-target="trip">Export<div class="ripple-container"></div></button></a>
                        </div>
                       
                    </div>
                    <div class="card-body">

                    <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('admin-country.name') }}</th>
                                        <th>{{ __('admin-country.name_arabic') }}</th>
                                        {{-- <th>Name Urdu</th> --}}
                                        <th>{{ __('admin-country.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($countries as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->name_arabic }}</td>
                                        {{-- <td>{{ $item->name_urdu }}</td> --}}
                                        <td>

                                            <a href="{{ url('/countries/' . $item->id) }}" title="{{ __('admin-country.view_country') }}" class="btn btn-info btn-sm">
                                                <i class="material-icons">
                                                    remove_red_eye
                                                </i>
                                            </a>

                                            <a href="{{ url('/countries/' . $item->id . '/edit') }}" title="{{ __('admin-country.edit_country') }}" class="btn btn-success btn-sm">
                                                <i class="material-icons">
                                                    edit
                                                </i>
                                            </a>
                                            @if(app()->getLocale() == 'ur')
                                                    {!! Html::form('DELETE', url('/ur/countries', $item->id), ['style' => 'display:inline'])->open() !!}
                                                @elseif(app()->getLocale() == 'ar')
                                                    {!! Html::form('DELETE', url('/ar/countries', $item->id), ['style' => 'display:inline'])->open() !!}
                                                @else
                                                    {!! Html::form('DELETE', url('/countries', $item->id), ['style' => 'display:inline'])->open() !!}
                                                @endif

                                                <button type="submit" class="btn btn-danger btn-sm" title="{{ __('admin-country.delete_country') }}" onclick="return confirm('Confirm delete?')">
                                                    <i class="material-icons" aria-hidden="true">delete</i>
                                                </button>
                                                
                                                

                                                {!! Html::form()->close() !!}

                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $countries->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('admin-additional-js')

@endsection
