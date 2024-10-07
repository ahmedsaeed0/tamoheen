@extends('layouts.admin.master')
@section('title')
Partnerpaymentmethods
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
                        <h4 class="card-title ">{{ __('admin-payment-method.partner_payment_method')}}</h4>
                        <a  href="{{ url('/partner-payment-methods/create') }}" class="btn btn-primary"> {{ __('admin-payment-method.add_new_partner_payment_method')}}</a>
                    </div>
                    <div class="card-body">

                    <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('admin-payment-method.user')}}</th>
                                        <th>{{ __('admin-payment-method.name')}}</th>
                                        <th>{{ __('admin-payment-method.details')}}</th>
                                        <th>{{ __('admin-payment-method.actions')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($partnerpaymentmethods as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->users->name }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->details }}</td>
                                        <td>

                                            <a href="{{ url('/partner-payment-methods/' . $item->id) }}" title="View PartnerPaymentMethod" class="btn btn-info btn-sm">
                                                <i class="material-icons">
                                                    remove_red_eye
                                                </i>
                                            </a>

                                            {{-- <a href="{{ url('/partner-payment-methods/' . $item->id . '/edit') }}" title="Edit PartnerPaymentMethod" class="btn btn-success btn-sm">
                                                <i class="material-icons">
                                                    edit
                                                </i>
                                            </a>

                                            {!! Form::open([
                                                'method'=>'DELETE',
                                                'url' => ['/partner-payment-methods', $item->id],
                                                'style' => 'display:inline'
                                            ]) !!}
                                                {!! Form::button('<i class="material-icons" aria-hidden="true">delete</i>', array(
                                                        'type' => 'submit',
                                                        'class' => 'btn btn-danger btn-sm',
                                                        'title' => 'Delete PartnerPaymentMethod',
                                                        'onclick'=>'return confirm("Confirm delete?")'
                                                )) !!}
                                            {!! Form::close() !!} --}}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $partnerpaymentmethods->appends(['search' => Request::get('search')])->render() !!} </div>
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
