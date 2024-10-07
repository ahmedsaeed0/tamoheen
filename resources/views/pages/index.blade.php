@extends('layouts.admin.master')
@section('title')
Pages
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
                            <h4 class="card-title ">@lang('admin-pages.pages')</h4>
                            <a  href="{{ url('/pages/create') }}" class="btn btn-primary"> @lang('admin-pages.add_new_page')</a>
                        </div>
                        <div><a href="{{url('/export-excel/pages')}}"><button class="btn btn-success btn-sm" data-target="trip">Export<div class="ripple-container"></div></button></a></div>
                        
                    </div>
                    <div class="card-body">
                        @foreach($pages as $item)
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p>@lang('admin-pages.title') : {{ $item->title }}</p>
                                        <p>@lang('admin-pages.title_arabic') : {{ $item->title_arabic }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p>@lang('admin-pages.status') :  
                                            @if($item->status == 1)
                                                @lang('admin-pages.active')
                                            @else
                                                @lang('admin-pages.deactive')
                                            @endif</p>                                        
                                    </div>
                                    <div class="col-md-12">
                                        @if($item->status == 1)
                                            <a href="{{ url('/pages/deactive/' . $item->id) }}" title="@lang('admin-pages.page_deactive')" class="btn btn-danger btn-sm">
                                                <i class="material-icons">
                                                    toggle_off
                                                </i>
                                            </a>
                                        @else
                                            <a href="{{ url('/pages/active/' . $item->id) }}" title="@lang('admin-pages.page_active')" class="btn btn-success btn-sm">
                                                <i class="material-icons">
                                                    toggle_on
                                                </i>
                                            </a>
                                        @endif

                                        <a href="{{ url('/pages/' . $item->id) }}" title="@lang('admin-pages.view_page')" class="btn btn-info btn-sm">
                                            <i class="material-icons">
                                                remove_red_eye
                                            </i>
                                        </a>

                                        <a href="{{ url('/pages/' . $item->id . '/edit') }}" title="@lang('admin-pages.edit_page')" class="btn btn-success btn-sm">
                                            <i class="material-icons">
                                                edit
                                            </i>
                                        </a>
                                        @if(app()->getLocale() == 'ur')
                                    <form method="POST" action="/ur/pages/{{ $item->id }}" style="display:inline">
                                        @csrf
                                        @method('DELETE')
                                @elseif(app()->getLocale() == 'ar')
                                    <form method="POST" action="/ar/pages/{{ $item->id }}" style="display:inline">
                                        @csrf
                                        @method('DELETE')
                                @else
                                    <form method="POST" action="/pages/{{ $item->id }}" style="display:inline">
                                        @csrf
                                        @method('DELETE')
                                @endif
                                    <button type="submit" class="btn btn-danger btn-sm" title="{{ __('admin-pages.delete_page') }}" onclick="return confirm('Confirm Delete?')">
                                        <i class="material-icons" aria-hidden="true">delete</i>
                                    </button>
                                </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <div class="pagination-wrapper"> {!! $pages->appends(['search' => Request::get('search')])->render() !!} </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('admin-additional-js')

@endsection
