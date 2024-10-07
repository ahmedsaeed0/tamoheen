@extends('layouts.admin.master')
@section('title')
Categories
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
                        <h4 class="card-title ">{{ __('admin-category.categories') }}</h4>
                        <a  href="{{ url('/categories/create') }}" class="btn btn-primary"> {{ __('admin-category.add_new_category') }}</a>
                    </div>
                    <div class="card-body">

                    <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('admin-category.name') }}</th>
                                        <th>{{ __('admin-category.name_arabic') }}</th>
                                        {{-- <th>Name Urdu</th> --}}
                                        <th>{{ __('admin-category.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($categories as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->name_arabic }}</td>
                                        {{-- <td>{{ $item->name_urdu }}</td> --}}
                                        <td>

                                            <a href="{{ url('/categories/' . $item->id) }}" title="{{ __('admin-category.view_category') }}" class="btn btn-info btn-sm">
                                                <i class="material-icons">
                                                    remove_red_eye
                                                </i>
                                            </a>

                                            <a href="{{ url('/categories/' . $item->id . '/edit') }}" title="{{ __('admin-category.edit_category') }}" class="btn btn-success btn-sm">
                                                <i class="material-icons">
                                                    edit
                                                </i>
                                            </a>
                                            @if(app()->getLocale() == 'ur')
                                                {!! Form::open([
                                                    'method'=>'DELETE',
                                                    'url' => ['/ur/categories', $item->id],
                                                    'style' => 'display:inline'
                                                ]) !!}
                                            @elseif(app()->getLocale() == 'ar')
                                                {!! Form::open([
                                                    'method'=>'DELETE',
                                                    'url' => ['/ar/categories', $item->id],
                                                    'style' => 'display:inline'
                                                ]) !!}
                                            @else
                                                {!! Form::open([
                                                    'method'=>'DELETE',
                                                    'url' => ['/categories', $item->id],
                                                    'style' => 'display:inline'
                                                ]) !!}
                                            @endif
                                                {!! Form::button('<i class="material-icons" aria-hidden="true">delete</i>', array(
                                                        'type' => 'submit',
                                                        'class' => 'btn btn-danger btn-sm',
                                                        'title' => __('admin-category.delete_category'),
                                                        'onclick'=>'return confirm("Confirm delete?")'
                                                )) !!}
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $categories->appends(['search' => Request::get('search')])->render() !!} </div>
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
