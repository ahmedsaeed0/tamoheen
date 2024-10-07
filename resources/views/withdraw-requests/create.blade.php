@extends('layouts.admin.master')
@section('title')
Create New WithdrawRequest
@endsection
@section('admin-additional-css')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/css/select2.min.css">
@endsection
@section('content')
<div class="content">
    @include('layouts.admin.include.alert')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">{{ __('admin-withdraw-request.create_new_withdraw_request')}}</h4>
                        <a  href="{{ url('/withdraw-requests') }}" class="btn btn-primary"> {{ __('admin-withdraw-request.back')}}</a>
                        <button class="btn btn-success">{{ __('admin-withdraw-request.amount')}}: {{ $partner_amount }}</button>
                    </div>
                    <div class="card-body">
                        @inject('html', 'Spatie\Html\Html')
                    
                        @if(app()->getLocale() == 'ur')
                                    <form method="POST" action="{{ url('/ur/withdraw-requests') }}" class="form-horizontal" enctype="multipart/form-data">
                                @elseif(app()->getLocale() == 'ar')
                                    <form method="POST" action="{{ url('/ar/withdraw-requests') }}" class="form-horizontal" enctype="multipart/form-data">
                                @else
                                    <form method="POST" action="{{ url('/withdraw-requests') }}" class="form-horizontal" enctype="multipart/form-data">
                                @endif

                                    @csrf
                                    @method('POST')

                                    @include('withdraw-requests.form', ['formMode' => 'create'])

                                </form>

                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('admin-additional-js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/js/select2.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {

        $('.js-example-basic-multiple').select2();
    });
</script>
@endsection
