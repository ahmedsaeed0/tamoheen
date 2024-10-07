@extends('layouts.admin.master')
@section('title')
Edit WithdrawRequest #{{ $withdrawrequest->id }}
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
                        <h4 class="card-title ">Edit WithdrawRequest #{{ $withdrawrequest->id }}</h4>
                        <a  href="{{ url('/withdraw-requests') }}" class="btn btn-primary"> Back</a>
                    </div>
                    <div class="card-body">

                        @if(app()->getLocale() == 'ur')
                        <form method="POST" action="{{ url('/ur/withdraw-requests/' . $withdrawrequest->id) }}" class="form-horizontal" enctype="multipart/form-data">
                    @elseif(app()->getLocale() == 'ar')
                        <form method="POST" action="{{ url('/ar/withdraw-requests/' . $withdrawrequest->id) }}" class="form-horizontal" enctype="multipart/form-data">
                    @else
                        <form method="POST" action="{{ url('/withdraw-requests/' . $withdrawrequest->id) }}" class="form-horizontal" enctype="multipart/form-data">
                    @endif
                    
                        @csrf
                        @method('POST')
                    
                        @include('withdraw-requests.form', ['formMode' => 'edit'])
                    
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
