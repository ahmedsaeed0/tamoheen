@extends('layouts.admin.master')
@section('title')
Sliders
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
                            <h4 class="card-title ">{{ __('admin-sliders.sliders') }}</h4>
                            <a  href="{{ url('/sliders/create') }}" class="btn btn-primary"> {{ __('admin-sliders.add_new_sliders') }}</a>
                        </div>
                        <div>
                            <a href="{{url('/export-excel/sliders')}}"><button class="btn btn-success btn-sm" data-target="trip">Export<div class="ripple-container"></div></button></a>
                        </div>
                    </div>
                    <div class="card-body">

                    <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('admin-sliders.title') }}</th>
                                        {{-- <th>Title Urdu</th> --}}
                                        <th>{{ __('admin-sliders.title_arabic') }}</th>
                                        <th>{{ __('admin-sliders.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($sliders as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->title }}</td>
                                        {{-- <td>{{ $item->title_urdu }}</td> --}}
                                        <td>{{ $item->title_arabic }}</td>
                                        <td>

                                            <a href="{{ url('/sliders/' . $item->id) }}" title="{{ __('admin-sliders.view_slider') }}" class="btn btn-info btn-sm">
                                                <i class="material-icons">
                                                    remove_red_eye
                                                </i>
                                            </a>

                                            <a href="{{ url('/sliders/' . $item->id . '/edit') }}" title="{{ __('admin-sliders.edit_slider') }}" class="btn btn-success btn-sm">
                                                <i class="material-icons">
                                                    edit
                                                </i>
                                            </a>
                                            @if(app()->getLocale() == 'ur')
                                            {!! html()->form('DELETE', url('/ur/sliders', $item->id))
                                                ->style('display:inline')
                                                ->open() !!}
                                           @elseif(app()->getLocale() == 'ar')
                                           {!! html()->form('DELETE', url('/ar/sliders', $item->id))
                                               ->style('display:inline')
                                               ->open() !!}
                                            @else
                                            {!! html()->form('DELETE', url('/sliders', $item->id))
                                                ->style('display:inline')
                                                ->open() !!}
                                            @endif
                                            {!! Html::form('DELETE', route('sliders.destroy', $item->id))
                                                ->style('display:inline')
                                                ->open() !!}
                                                
                                                {!! Html::button('<i class="material-icons" aria-hidden="true">delete</i>')
                                                    ->type('submit')
                                                    ->class('btn btn-danger btn-sm')
                                                    ->attribute('title', __('admin-sliders.delete_slider'))
                                                    ->attribute('onclick', 'return confirm("Confirm delete?")') !!}

                                            {!! Html::form()->close() !!}

                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
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
