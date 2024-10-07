@extends('layouts.admin.master')
@section('title')
Products
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
                        <h4 class="card-title ">{{ __('admin-product.products') }}</h4>
                        <a  href="{{ url('/products/create') }}" class="btn btn-primary"> {{ __('admin-product.add_new_product') }}</a>
                    </div>
                    <div class="card-body">

                    <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('admin-product.category') }}</th>
                                        <th>{{ __('admin-product.name') }}</th>
                                        <th>{{ __('admin-product.name_arabic') }}</th>
                                        <th>{{ __('admin-product.price') }}</th>
                                        <th>{{ __('admin-product.status') }}</th>
                                        <th>{{ __('admin-product.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($products as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->categories->name }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->name_arabic }}</td>
                                        <td>{{ $item->price }}</td>
                                        <td>
                                            @if($item->status == 1)
                                                <span class="badge badge-success">{{ __('admin-product.active') }}</span>
                                            @else
                                                <span class="badge badge-danger">{{ __('admin-product.deactive') }}</span>
                                            @endif
                                        </td>
                                        <td>

                                            <a href="{{ url('/products/' . $item->id) }}" title="{{ __('admin-product.view_product') }}" class="btn btn-info btn-sm">
                                                <i class="material-icons">
                                                    remove_red_eye
                                                </i>
                                            </a>

                                            <a href="{{ url('/products/' . $item->id . '/edit') }}" title="{{ __('admin-product.edit_product') }}" class="btn btn-success btn-sm">
                                                <i class="material-icons">
                                                    edit
                                                </i>
                                            </a>
                                            @if(app()->getLocale() == 'ur')
                                                {!! Form::open([
                                                    'method'=>'DELETE',
                                                    'url' => ['/ur/products', $item->id],
                                                    'style' => 'display:inline'
                                                ]) !!}
                                            @elseif(app()->getLocale() == 'ar')
                                                {!! Form::open([
                                                    'method'=>'DELETE',
                                                    'url' => ['/ar/products', $item->id],
                                                    'style' => 'display:inline'
                                                ]) !!}
                                            @else
                                                {!! Form::open([
                                                    'method'=>'DELETE',
                                                    'url' => ['/products', $item->id],
                                                    'style' => 'display:inline'
                                                ]) !!}
                                            @endif
                                                {!! Form::button('<i class="material-icons" aria-hidden="true">delete</i>', array(
                                                        'type' => 'submit',
                                                        'class' => 'btn btn-danger btn-sm',
                                                        'title' => __('admin-product.delete_product'),
                                                        'onclick'=>'return confirm("Confirm delete?")'
                                                )) !!}
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $products->appends(['search' => Request::get('search')])->render() !!} </div>
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
