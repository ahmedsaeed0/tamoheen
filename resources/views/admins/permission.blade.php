@extends('layouts.admin.master')
@section('title')
Admins
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
		              	<h4 class="card-title ">{{ __('admin-permission.permission_list') }}</h4>
		            </div>
		            <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ url('permission-update') }}" method="post">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $admin->id }}">
                            @foreach($permissions as $permission)
                            @if(in_array($permission->id, $user_permission_ids))
                                <div class="">
                                    <input type="checkbox" value="{{ $permission->id }}" id="" name="permission_id[]" checked />
                                    <label class="form-check-label" for="flexCheckChecked">
                                        {{ Str::upper(str_replace('_',' ',$permission->name)) }}
                                    </label>
                                </div>
                            @else
                                <div class="">
                                    <input type="checkbox" value="{{ $permission->id }}" id="" name="permission_id[]" />
                                    <label class="form-check-label" for="flexCheckChecked">
                                        {{ Str::upper(str_replace('_',' ',$permission->name)) }}
                                    </label>
                                </div>
                            @endif
                            <hr>
                            @endforeach
                            <div class="form-group">
                                <label for=""></label>
                                <button type="submit" class="btn btn-success">{{ __('admin-permission.update') }}</button>
                            </div>
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
