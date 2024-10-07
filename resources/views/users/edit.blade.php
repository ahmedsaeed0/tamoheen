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
</style>
@endsection
@section('content')
<div class="content">
	<div class="container-fluid">
      @if ($errors->any())
        <div class="alert alert-danger">
            <ul style="margin-bottom: 0rem;">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        @if (Session::has('success'))
        <div class="alert alert-success" role="success">
            {{ Session::get('success') }}
        </div>
        @endif
        @if (Session::has('error'))
        <div class="alert alert-danger" role="success">
            {{ Session::get('error') }}
        </div>
        @endif
	  	<div class="row">
		    <div class="col-md-12">
	          	<div class="card">
		            <div class="card-header card-header-primary">
		              	<h4 class="card-title ">@lang('admin-users.edit_user') # {{ $user->name }}</h4>
		            </div>
		            <div class="card-body">
		            	<a href="{{ url('/users/partner') }}" title="Back">
		            		<button class="btn btn-warning btn-sm">
		            			<i class="fa fa-arrow-left" aria-hidden="true"></i>
		            		</button>
		            	</a>
                        <br />
                        <br />
						@if(app()->getLocale() == 'ur')
						<form action="{{ url('/ur/users', $user->id) }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
					@elseif(app()->getLocale() == 'ar')
						<form action="{{ url('/ar/users', $user->id) }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
					@else
						<form action="{{ url('/users', $user->id) }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
					@endif

						@csrf
						@method('PATCH')

						@if($user->hasrole('admin'))
							@include('users.form', ['formMode' => 'edit'])
						@else
							@include('users.edit-form', ['formMode' => 'edit'])
						@endif

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
