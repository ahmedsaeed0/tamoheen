@extends('layouts.admin.master')
@section('title')
Create New PartnerPaymentHostory
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
                        <h4 class="card-title ">Create New PartnerPaymentHostory</h4>
                        <a  href="{{ url('/partner-payment-hostories') }}" class="btn btn-primary"> Back</a>
                    </div>
                    <div class="card-body">

                        <form action="{{ app()->getLocale() == 'ur' ? '/ur/partner-payment-hostories' : (app()->getLocale() == 'ar' ? '/ar/partner-payment-hostories' : '/partner-payment-hostories') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                            @csrf
                        
                            @include ('partner-payment-hostories.form', ['formMode' => 'create'])
                        
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
