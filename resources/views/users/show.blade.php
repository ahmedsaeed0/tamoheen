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

		            	<a href="{{ url('/users/partner') }}" title="Back">

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

                                    	<th> {{ __('admin-users.date_of_register') }} </th>

                                    	<td> {{ Carbon\Carbon::parse($user->created_at)->format('d-M-Y  g:i:s A' ) }}</td>

                                    </tr>

                                    <tr>

                                    	<th> {{ __('admin-users.role') }} </th>

                                    	<td> {{ $user->getRoleNames() }} </td>

                                    </tr>

                                    <tr>

                                    	<th> {{ __('admin-users.mobile') }} </th>

                                    	<td> {{ $user->mobile }} </td>

                                    </tr>

                                    @if($user->identity_type != null)

                                    <tr>

                                    	<th> {{ __('admin-users.identity_type') }} </th>

                                    	<td>

                                    		@if($user->identity_type == 1)

                                    			<span class="text-primary">{{ __('admin-users.nid') }}</span>

                                    		@elseif($user->identity_type == 2)

                                    			<span class="text-primary">{{ __('admin-users.passport') }}</span>

                                            @else

                                                <span class="text-primary">{{ __('admin-users.iqma') }}</span>

                                    		@endif

                                    	</td>

                                    </tr>

                                    @endif

                                    @if($user->identity_number != null)

                                    <tr>

                                    	<th> {{ __('admin-users.identity_number') }} </th>

                                    	<td> {{ $user->identity_number }} </td>

                                    </tr>

                                    @endif

                                    @if($user->image != null)

                                    <tr>

                                    	<th> {{ __('admin-users.user_image') }} </th>

                                    	<td> <img src="{{ $user->image->url }}" alt="{{ $user->name }}" id="userImg" /> </td>

                                    </tr>

                                    @endif



                                    @if($user->partnerMetas != null)

                                        <tr>

                                            <th> {{ __('admin-users.address') }} </th>

                                            <td>{{ $user->partnerMetas->address }}</td>

                                        </tr>

                                        <tr>

                                            <th> {{ __('admin-users.license_number') }} </th>

                                            <td>{{ $user->partnerMetas->license_number }}</td>

                                        </tr>

                                        <tr>

                                            <th> {{ __('admin-users.license_file') }} </th>

                                            <td>

                                                <a href="{{ $user->partnerMetas->license_file }}" download="{{ $user->partnerMetas->license_file }}" class="btn btn-success btn-sm">

                                                    <i class="material-icons">

                                                        cloud_download

                                                    </i>

                                                    {{ $user->partnerMetas->license_number }}

                                                </a>

                                            </td>

                                        </tr>



                                    @endif

                                    <tr>

                                        <th colspan="2">Payment Methods</th>

                                    </tr>

                                    @if($payment_method!=null)

                                    @foreach($payment_method as $r)

                                    <tr>

                                        <td>

                                        {{ $r->name }}

                                        </td>

                                        <td>

                                        {{ $r->details }}

                                        </td>

                                    </tr>

                                    @endforeach

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

