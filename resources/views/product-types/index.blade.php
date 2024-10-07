@extends('layouts.admin.master')
@section('title')
Product Types
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
                            <h4 class="card-title ">{{ __('admin-product-type.product_types') }}</h4>
                            <a  href="{{ url('/product-types/create') }}" class="btn btn-primary"> {{ __('admin-product-type.add_new_product_type') }}</a>
                        </div>
                        <div>
                            <a href="{{url('/export-excel/product-types')}}"><button class="btn btn-success btn-sm" data-target="trip">Export<div class="ripple-container"></div></button></a>
                        </div>
                    </div>
                    <div class="card-body">

                    <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('admin-product-type.name') }}</th>
                                        <th>{{ __('admin-product-type.name_arabic') }}</th>
                                        {{-- <th>Name Urdu</th> --}}
                                        <th>{{ __('admin-product-type.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($producttypes as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->name_arabic }}</td>
                                        {{-- <td>{{ $item->name_urdu }}</td> --}}
                                        <td>

                                            <a href="{{ url('/product-types/' . $item->id) }}" title="{{ __('admin-product-type.view_product_type') }}" class="btn btn-info btn-sm">
                                                <i class="material-icons">
                                                    remove_red_eye
                                                </i>
                                            </a>

                                            <a href="{{ url('/product-types/' . $item->id . '/edit') }}" title="{{ __('admin-product-type.edit_product_type') }}" class="btn btn-success btn-sm">
                                                <i class="material-icons">
                                                    edit
                                                </i>
                                            </a>
                                            <form method="POST" action="{{ app()->getLocale() == 'ur' ? url('/ur/product-types', $item->id) : (app()->getLocale() == 'ar' ? url('/ar/product-types', $item->id) : url('/product-types', $item->id)) }}" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                            
                                                <button type="submit" class="btn btn-danger btn-sm" title="{{ __('admin-sliders.delete_slider') }}" onclick="return confirm('Confirm delete?')">
                                                    <i class="material-icons" aria-hidden="true">delete</i>
                                                </button>
                                            </form>
                                            
                                                
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $producttypes->appends(['search' => Request::get('search')])->render() !!} </div>
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
