@extends('layouts.admin.master')
@section('title')
Terms
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
                        <h4 class="card-title ">Terms</h4>
                        @if(count($terms) == 0)
                        <a  href="{{ url('/terms/create') }}" class="btn btn-primary"> Add New Terms</a>
                        @endif
                    </div>
                    <div class="card-body">

                    <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Description</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($terms as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ Str::words($item->description, 10, '...') }}</td>
                                        <td>

                                            <a href="{{ url('/terms/' . $item->id) }}" title="View Term" class="btn btn-info btn-sm">
                                                <i class="material-icons">
                                                    remove_red_eye
                                                </i>
                                            </a>

                                            <a href="{{ url('/terms/' . $item->id . '/edit') }}" title="Edit Term" class="btn btn-success btn-sm">
                                                <i class="material-icons">
                                                    edit
                                                </i>
                                            </a>

                                            {{--  {!! Form::open([
                                                'method'=>'DELETE',
                                                'url' => ['/terms', $item->id],
                                                'style' => 'display:inline'
                                            ]) !!}
                                                {!! Form::button('<i class="material-icons" aria-hidden="true">delete</i>', array(
                                                        'type' => 'submit',
                                                        'class' => 'btn btn-danger btn-sm',
                                                        'title' => 'Delete Term',
                                                        'onclick'=>'return confirm("Confirm delete?")'
                                                )) !!}
                                            {!! Form::close() !!}  --}}
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