@extends('layouts.admin.master')
@section('title')
Edit PartnerPaymentMethod #{{ $partnerpaymentmethod->id }}
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
                        <h4 class="card-title ">{{ __('admin-payment-method.edit_partner_payment_method')}} #{{ $partnerpaymentmethod->id }}</h4>
                        <a  href="{{ url('/partner-payment-methods') }}" class="btn btn-primary"> {{ __('admin-payment-method.back')}}</a>
                    </div>
                    <div class="card-body">
                        @if(app()->getLocale() == 'ur')
                        <form method="POST" action="{{ url('/ur/partner-payment-methods/' . $partnerpaymentmethod->id) }}" class="form-horizontal" enctype="multipart/form-data">
                    @elseif(app()->getLocale() == 'ar')
                        <form method="POST" action="{{ url('/ar/partner-payment-methods/' . $partnerpaymentmethod->id) }}" class="form-horizontal" enctype="multipart/form-data">
                    @else
                        <form method="POST" action="{{ url('/partner-payment-methods/' . $partnerpaymentmethod->id) }}" class="form-horizontal" enctype="multipart/form-data">
                    @endif

                        @csrf
                        @include('partner-payment-methods.form', ['formMode' => 'edit'])

                    </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('admin-additional-js')
@endsection
