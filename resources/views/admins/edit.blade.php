@extends('layouts.admin.master')
@section('title')
User Edit # {{ $user->name }}
@endsection
@section('admin-additional-css')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/css/select2.min.css">
<style type="text/css">
	#user_image{
		opacity: 1 !important;
		position: unset;
	}
	.form-group input[type=file]{
		opacity: 1 !important;
		position: relative !important;
		z-index: 1 !important;
	}
	#userImg{
		width: 200px;
		height: 200px;
	}

    .select2-results__options{
        text-align: start !important;
    }
</style>
@endsection
@section('content')
<div class="content">
	<div class="container-fluid">
	  	<div class="row">
		    <div class="col-md-12">
	          	<div class="card">
		            <div class="card-header card-header-primary">
		              	<h4 class="card-title ">@lang('admin-users.edit_user') # {{ $user->name }}</h4>
		            </div>
		            <div class="card-body">
		            	<a href="{{ url('/admins') }}" title="{{ __('admin-users.back') }}">
		            		<button class="btn btn-warning btn-sm">
		            			<i class="fa fa-arrow-left" aria-hidden="true"></i>
		            		</button>
		            	</a>
                        <br />
                        <br />

						@if(app()->getLocale() == 'ur')
								{!! html()->form('PATCH', url('/ur/admins', $user->id), ['class' => 'form-horizontal', 'files' => true])->open() !!}
							@elseif(app()->getLocale() == 'ar')
								{!! html()->form('PATCH', url('/ar/admins', $user->id), ['class' => 'form-horizontal', 'files' => true])->open() !!}
							@else
								{!! html()->form('PATCH', url('/admins', $user->id), ['class' => 'form-horizontal', 'files' => true])->open() !!}
							@endif

							@if($user->hasrole(['admin', 'sub_admin']))
								@include('admins.form', ['formMode' => 'edit'])
							@else
								@include('admins.edit-form', ['formMode' => 'edit'])
							@endif

							{!! html()->form()->close() !!}


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
