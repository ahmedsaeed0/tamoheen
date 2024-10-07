@extends('layouts.admin.master')
@section('title')
Edit PartnerPaymentHostory #{{ $partnerpaymenthostory->id }}
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
                        <h4 class="card-title ">Edit PartnerPaymentHostory #{{ $partnerpaymenthostory->id }}</h4>
                        <a  href="{{ url('/partner-payment-hostories') }}" class="btn btn-primary"> Back</a>
                    </div>
                    <div class="card-body">

                        <form action="{{ app()->getLocale() == 'ur' ? '/ur/partner-payment-hostories/' . $partnerpaymenthostory->id : (app()->getLocale() == 'ar' ? '/ar/partner-payment-hostories/' . $partnerpaymenthostory->id : '/partner-payment-hostories/' . $partnerpaymenthostory->id) }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                        
                            @include('partner-payment-hostories.form', ['formMode' => 'edit'])
                        
                            <button type="submit" class="btn btn-primary">{{ $formMode === 'edit' ? __('admin-partner-payment-hostories.update') : __('admin-partner-payment-hostories.create') }}</button>
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
