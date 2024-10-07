@extends('layouts.admin.master')

@section('title')

Show of # {{ $user->name }}

@endsection

@section('admin-additional-css')

<style type="text/css">

	#user_image{

		opacity: 1 !important;

		position: unset;

	}

	#userImg{

		width: 200px;

		height: 200px;

	}

	.card .table tr:first-child td {

		border-top: 1px solid #ddd;

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

		              	<h4 class="card-title ">{{ __('admin-users.show_of') }} # {{ $user->name }}</h4>

		            </div>

		            <div class="card-body">

		            	<a href="{{ url('/admins') }}" title="{{ __('admin-users.back') }}">

		            		<button class="btn btn-warning btn-sm">

		            			<i class="fa fa-arrow-left" aria-hidden="true"></i>

		            		</button>

		            	</a>

                        <br />

                        <br />



                        <div class="table-responsive">

                            <table class="table table-bordered">

                                <tbody>

                                    <tr>

                                        <th>{{ __('admin-users.id') }}</th>

                                        <td>{{ $user->id }}</td>

                                    </tr>

                                    <tr>

                                    	<th> {{ __('admin-users.title') }} </th>

                                    	<td>

                                    		@if($user->title == 1)

                                    			<span class="text-primary">Mr</span>

                                    		@else

                                    			<span class="text-primary">Mrs</span>

                                    		@endif

                                    	</td>

                                    </tr>

                                    <tr>

                                    	<th> {{ __('admin-users.name') }} </th>

                                    	<td> {{ $user->name }} </td>

                                    </tr>

                                    <tr>

                                    	<th> {{ __('admin-users.email') }} </th>

                                    	<td> {{ $user->email }} </td>

                                    </tr>

                                    <tr>

                                    	<th> {{ __('admin-users.role') }} </th>

                                    	<td> {{ $user->getRoleNames() }} </td>

                                    </tr>

                                    <tr>

                                    	<th> {{ __('admin-users.mobile') }} </th>

                                    	<td> {{ $user->mobile }} </td>

                                    </tr>



                                    @if($user->image != null)

                                    <tr>

                                    	<th> {{ __('admin-users.user_image') }} </th>

                                    	<td> <img src="{{ $user->image->url }}" alt="{{ $user->name }}" id="userImg" /> </td>

                                    </tr>

                                    @endif

                                </tbody>

                            </table>

                        </div>

		            </div>

	          	</div>

	        </div>

	  	</div>

	</div>

</div>

@endsection

@section('admin-additional-js')



@endsection

