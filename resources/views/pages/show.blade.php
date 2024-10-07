@extends('layouts.admin.master')
@section('title')
Page {{ $page->id }}
@endsection
@section('admin-additional-css')
<style type="text/css">
    .card .table tr:first-child td {
        border-top: 1px solid #ddd;
    }
</style>
@endsection
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">@lang('admin-pages.page') {{ $page->id }}</h4>
                        <a  href="{{ url('/pages') }}" class="btn btn-primary"> @lang('admin-pages.back')</a>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>#</th>
                                        <td>{{ $page->id }}</td>
                                    </tr>
                                    <tr>
                                        <th> @lang('admin-pages.title') </th>
                                        <td> {{ $page->title }} </td>
                                    </tr>
                                    <tr>
                                        <th> @lang('admin-pages.title_arabic') </th>
                                        <td> {{ $page->title_arabic }} </td>
                                    </tr>
                                   
                                    <tr>
                                        <th> @lang('admin-pages.content') </th>
                                        <td> {!! $page->content !!} </td>
                                    </tr>
                                    <tr>
                                        <th> @lang('admin-pages.content_arabic') </th>
                                        <td> {!! $page->content_arabic !!} </td>
                                    </tr>
                                   
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
