@extends('layouts.admin.master')
@section('title')
Withdrawrequests
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
                        <h4 class="card-title ">Withdrawrequests</h4>
                        <a href="{{url('/export-excel/pending-withdraw-requests')}}"><button class="btn btn-success btn-sm" data-target="trip">Export<div class="ripple-container"></div></button></a>
                    </div>
                    <div class="card-body">

                    <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                       <!-- <th>#</th>
                                        <th>{{ __('admin-withdraw-accept.partner') }}</th>
                                        <th>{{ __('admin-withdraw-accept.payment_method') }}</th>-->
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('admin-withdraw-accept.amount') }}</th>
                                        <th>{{ __('admin-withdraw-accept.status') }}</th>
                                        @role('admin')
                                        <th>{{ __('admin-withdraw-accept.actions') }}</th>
                                        @endrole
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($withdrawrequests as $item)
                                    <tr>
                                       <!-- <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->partner_id }}</td>
                                        <td>{{ $item->payment_method }}</td>-->
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->amount }}</td>
                                        <td>
                                            @if($item->status == 1)
                                                <span class="badge badge-success">{{ __('admin-withdraw-accept.accept') }}</span>
                                            @else
                                                <span class="badge badge-danger">{{ __('admin-withdraw-accept.pending') }}</span>
                                            @endif
                                        </td>
                                        @role('admin')
                                        <td>
                                            @if($item->status == 0)
                                                <a href="{{ url('/withdraw-requests-accept/' . $item->id) }}" title="{{ __('admin-withdraw-accept.accept_withdraw') }}" class="btn btn-info btn-sm">
                                                    {{ __('admin-withdraw-accept.accept') }}
                                                </a>
                                            @endif

                                            {{-- <a href="{{ url('/withdraw-requests/' . $item->id) }}" title="View WithdrawRequest" class="btn btn-info btn-sm">
                                                <i class="material-icons">
                                                    remove_red_eye
                                                </i>
                                            </a> --}}

                                            {{-- <a href="{{ url('/withdraw-requests/' . $item->id . '/edit') }}" title="Edit WithdrawRequest" class="btn btn-success btn-sm">
                                                <i class="material-icons">
                                                    edit
                                                </i>
                                            </a>

                                            {!! Form::open([
                                                'method'=>'DELETE',
                                                'url' => ['/withdraw-requests', $item->id],
                                                'style' => 'display:inline'
                                            ]) !!}
                                                {!! Form::button('<i class="material-icons" aria-hidden="true">delete</i>', array(
                                                        'type' => 'submit',
                                                        'class' => 'btn btn-danger btn-sm',
                                                        'title' => 'Delete WithdrawRequest',
                                                        'onclick'=>'return confirm("Confirm delete?")'
                                                )) !!}
                                            {!! Form::close() !!} --}}
                                        </td>
                                        @endrole
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $withdrawrequests->appends(['search' => Request::get('search')])->render() !!} </div>
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
