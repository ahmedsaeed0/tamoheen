@extends('layouts.admin.master')
@section('title')
Change Password
@endsection
@section('admin-additional-css')
<style type="text/css">
    .table-responsive>.table-bordered{
        border: 1;
    }
</style>
@endsection
@section('content')
<div class="content">
    @include('layouts.admin.include.alert')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">Change Password</h4>
                        <a  href="{{ url('/home') }}" class="btn btn-primary"> Back</a>
                    </div>
                    <div class="card-body">

                        @if(app()->getLocale() == 'ur')
                            <form method="POST" action="{{ url('/ur/change-password') }}" class="form-horizontal" enctype="multipart/form-data">
                        @elseif(app()->getLocale() == 'ar')
                            <form method="POST" action="{{ url('/ar/change-password') }}" class="form-horizontal" enctype="multipart/form-data">
                        @else
                            <form method="POST" action="{{ url('/change-password') }}" class="form-horizontal" enctype="multipart/form-data">
                        @endif

                            @csrf
                            @method('POST')

                            <div class="form-group">
                                <label for="old_password" class="control-label">Old Password</label>
                                <input type="password" name="old_password" id="old_password" class="form-control" required>
                            </div>
                        
                            <div class="form-group">
                                <label for="new_password" class="control-label">New Password</label>
                                <input type="password" name="new_password" id="new_password" class="form-control" required>
                            </div>
                        
                            <div class="form-group">
                                <label for="confirm_password" class="control-label">Confirm Password</label>
                                <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                            </div>
                        
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        
                        </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('admin-additional-js')
@endsection
