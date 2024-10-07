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
		            <div class="card-header card-header-primary d-flex justify-content-between align-items-center">
						<div>
							<h4 class="card-title ">@lang('admin-users.user_list')</h4>
							<a  href="{{ url('admins/create') }}" class="btn btn-primary"> @lang('admin-users.add_new_admin')</a>
						</div>
						<div><a href="{{url('/export-excel/admins')}}"><button class="btn btn-success btn-sm" data-target="trip">Export<div class="ripple-container"></div></button></a></div>
		            </div>
		            <div class="card-body">
						@foreach($admins as $item)
							<div class="card">
								<div class="card-body">
									<div class="row">
										<div class="col-md-12">
											<div class="row">
												<div class="col-md-6">
													<p>@lang('admin-users.name') : {{ $item->name }}</p>
													<p>@lang('admin-users.email'): {{ $item->email }}</p>
												</div>
												<div class="col-md-6">
													<p>@lang('admin-users.status') : 
														@if($item->status == 1)
															<span class="text-primary">@lang('admin-users.active')</span>
														@else
															<span class="text-danger">@lang('admin-users.inactive')</span>
														@endif
													</p>
													<p>@lang('admin-users.role') : {{ $item->getRoleNames() }}</p>													
												</div>
											</div>
											
										</div>
										<div class="col-md-12">
											@if($item->id != Auth::id())
					                      		@if($item->status == 1)
	                                                <a href="{{ url('/admin-inactive/' . $item->id) }}" title="{{ __('admin-users.inactive_user') }}" class="btn btn-warning btn-sm">
	                                                    <i class="material-icons" aria-hidden="true">
	                                                    	arrow_downward
	                                                    </i>
	                                                </a>
	                                            @else
	                                                <a href="{{ url('/admin-active/' . $item->id) }}" title="{{ __('admin-users.active_user') }}" class="btn btn-success btn-sm">
	                                                    <i class="material-icons" aria-hidden="true">
	                                                    	arrow_upward
	                                                    </i>
	                                                </a>
	                                            @endif
                                            @endif
				                      		<a href="{{ url('admins/'.$item->id) }}" title="{{ __('admin-users.view_user') }}" class="btn btn-info btn-sm">
			                      				<i class="material-icons">
			                      					remove_red_eye
			                      				</i>
				                      		</a>
											@if($item->id != Auth::id())
				                      		<a href="{{ url('admins/'.$item->id.'/edit') }}" title="{{ __('admin-users.edit_user')}}" class="btn btn-success btn-sm">
			                      				<i class="material-icons">
													edit
			                      				</i>
				                      		</a>
											@endif

                                            @role('admin')
                                                @if(Auth::id() != $item->id)
                                                    <a href="{{ url('admins/'.$item->id.'/permissions') }}" title="{{ __('admin-users.view_user') }}" class="btn btn-primary btn-sm">
                                                        <span class="material-icons">
                                                            admin_panel_settings
                                                        </span>
                                                    </a>
                                                @endif
                                            @endrole
				                      		{{-- @if($item->id != Auth::id())
				                      		{!! Form::open([
                                                'method'=>'DELETE',
                                                'url' => ['/users', $item->id],
                                                'style' => 'display:inline'
                                            ]) !!}
                                                {!! Form::button('<i class="material-icons" aria-hidden="true">delete</i>', array(
                                                        'type' => 'submit',
                                                        'class' => 'btn btn-danger btn-sm',
                                                        'title' => 'Delete User',
                                                        'onclick'=>'return confirm("Confirm delete?")'
                                                )) !!}
                                            {!! Form::close() !!}
                                            @endif --}}
										</div>
									</div>
								</div>
							</div>
						@endforeach
						<div class="pagination-wrapper"> {!! $admins->appends(['search' => Request::get('search')])->render() !!} </div>
		            </div>
	          	</div>
	        </div>
	  	</div>
	</div>
</div>
@endsection
@section('admin-additional-js')

@endsection
