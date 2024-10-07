@extends('layouts.admin.master')
@section('title')
States
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
                            <h4 class="card-title ">{{ __('admin-state.states') }}</h4>
                            <a  href="{{ url('/states/create') }}" class="btn btn-primary"> {{ __('admin-state.add_new_state') }}</a>
                        </div>
                        <div>
                            <a href="{{url('/export-excel/states')}}"><button class="btn btn-success btn-sm" data-target="trip">Export<div class="ripple-container"></div></button></a>
                        </div>
                       
                    </div>
                    <div class="card-body">

                    <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('admin-state.country') }}</th>
                                        <th>{{ __('admin-state.name') }}</th>
                                        <th>{{ __('admin-state.name_arabic') }}</th>
                                        {{-- <th>Name Urdu</th> --}}
                                        <th>{{ __('admin-state.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($states as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->countries->name ?? '' }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->name_arabic }}</td>
                                        {{-- <td>{{ $item->name_urdu }}</td> --}}
                                        <td>

                                            <a href="{{ url('/states/' . $item->id) }}" title="{{ __('admin-state.view_state') }}" class="btn btn-info btn-sm">
                                                <i class="material-icons">
                                                    remove_red_eye
                                                </i>
                                            </a>

                                            <a href="{{ url('/states/' . $item->id . '/edit') }}" title="{{ __('admin-state.edit_state') }}" class="btn btn-success btn-sm">
                                                <i class="material-icons">
                                                    edit
                                                </i>
                                            </a>
                                            @if(app()->getLocale() == 'ur')
                                            <form method="POST" action="{{ url('/ur/states', $item->id) }}" style="display:inline" onsubmit="return confirm('Confirm delete?')">
                                            @csrf <!-- إضافة توكن CSRF -->
                                            @method('DELETE') <!-- إضافة طريقة DELETE -->
                                        @elseif(app()->getLocale() == 'ar')
                                            <form method="POST" action="{{ url('/ar/states', $item->id) }}" style="display:inline" onsubmit="return confirm('Confirm delete?')">
                                            @csrf
                                            @method('DELETE')
                                        @else
                                            <form method="POST" action="{{ url('/states', $item->id) }}" style="display:inline" onsubmit="return confirm('Confirm delete?')">
                                            @csrf
                                            @method('DELETE')
                                        @endif
                                            <button type="submit" class="btn btn-danger btn-sm" title="{{ __('admin-state.delete_state') }}">
                                                <i class="material-icons" aria-hidden="true">delete</i>
                                            </button>
</form>

                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $states->appends(['search' => Request::get('search')])->render() !!} </div>
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
