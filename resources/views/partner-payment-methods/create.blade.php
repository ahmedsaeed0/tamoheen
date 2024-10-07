@extends('layouts.admin.master')
@section('title')
Create New PartnerPaymentMethod
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
                        <h4 class="card-title ">{{ __('admin-payment-method.create_new_partner_payment_method')}}</h4>
                        <a  href="{{ url('/partner-payment-methods') }}" class="btn btn-primary"> Back</a>
                    </div>
                    <div class="card-body">
                        {{-- @inject('html', 'Spatie\Html\Html')  --}}
                    
                        @if(app()->getLocale() == 'ur')
                                <form method="POST" action="{{ url('/ur/partner-payment-methods') }}" class="form-horizontal" enctype="multipart/form-data">
                            @elseif(app()->getLocale() == 'ar')
                                <form method="POST" action="{{ url('/ar/partner-payment-methods') }}" class="form-horizontal" enctype="multipart/form-data">
                            @else
                                <form method="POST" action="{{ url('/partner-payment-methods') }}" class="form-horizontal" enctype="multipart/form-data">
                            @endif

                                @csrf
                                @include('partner-payment-methods.form', ['formMode' => 'create'])

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
