@extends('layouts.admin.master')
@section('title')
Cities
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
                            <h4 class="card-title ">{{ __('admin-city.cities') }}</h4>
                            <a  href="{{ url('/cities/create') }}" class="btn btn-primary"> {{ __('admin-city.add_new_city') }}</a>
                        </div>
                        <div>
                            <a href="{{url('/export-excel/cities')}}"><button class="btn btn-success btn-sm" data-target="trip">Export<div class="ripple-container"></div></button></a>
                        </div>
                      
                    </div>
                    <div class="card-body">

                    <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('admin-city.state') }}</th>
                                        <th>{{ __('admin-city.name') }}</th>
                                        <th>{{ __('admin-city.name_arabic') }}</th>
                                        <th>{{ __('admin-city.order_by') }}</th>
                                        {{-- <th>Name Urdu</th> --}}
                                        <th>{{ __('admin-city.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($cities as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @if($item->states)
                                                @if(app()->getLocale() == 'ar')
                                                    {{ $item->states->name_arabic }}
                                                @else
                                                    {{ $item->states->name }}
                                                @endif
                                            @else
                                                {{ __('No state available') }}
                                            @endif
                                        </td>
                                        
                                        <td>
                                            {{ $item->name }}
                                        </td>
                                        <td>{{ $item->name_arabic }}</td>
                                        <td>{{ $item->city_order }}</td>
                                        <td>

                                            <a href="{{ url('/cities/' . $item->id) }}" title="{{ __('admin-city.view_city') }}" class="btn btn-info btn-sm">
                                                <i class="material-icons">
                                                    remove_red_eye
                                                </i>
                                            </a>

                                            <a href="{{ url('/cities/' . $item->id . '/edit') }}" title="{{ __('admin-city.edit_city') }}" class="btn btn-success btn-sm">
                                                <i class="material-icons">
                                                    edit
                                                </i>
                                            </a>
                                            
                                            <form method="POST" action="{{ url('/cities/' . $item->id) }}" style="display:inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="{{ __('admin-city.delete_city') }}" onclick="return confirm('Confirm delete?')">
                                                    <i class="material-icons" aria-hidden="true">delete</i>
                                                </button>
                                            </form>
                                            
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $cities->appends(['search' => Request::get('search')])->render() !!} </div>
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
