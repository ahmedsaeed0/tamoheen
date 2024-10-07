@extends('layouts.admin.master')

@section('title')

Users

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

                        <div class="row">

                            <div class="col-md-6">

                                <h4 class="card-title ">@lang('admin-users.user_list')</h4>

                            </div>

                            <div class="col-md-6 ">

                               <a href="{{url('/export-excel/'.$type)}}" class="float-right"><button class="btn btn-success btn-sm" data-target="trip">Export<div class="ripple-container"></div></button></a>

                            </div>

                        </div>

                    </div>

                    <div class="card-body">
                    
                        @foreach($users as $item)

                        <div class="card">

                            <div class="card-body">

                                <div class="row">

                                    <div class="col-md-6">

                                        <p>@lang('admin-users.create_date') : {{$item->created_at}}</p>

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

                                    <div class="col-md-12">

                                        @if($item->id != Auth::id())

                                        @if($item->status == 1)

                                        <?php 	

														$url = ""; 

												  		if(Lang::locale()=='en') { 

															$url = url('/user-inactive/' . $item->id);

														}else{

															$url = url('/ar/user-inactive/' . $item->id);

														}

													?>

                                        <a href="{{ $url }}" title="{{ __('admin-users.inactive_user') }}"

                                            class="btn btn-warning btn-sm">

                                            <i class="material-icons" aria-hidden="true">

                                                arrow_downward

                                            </i>

                                        </a>

                                        @else

                                        <?php 	

														$url = ""; 

												  		if(Lang::locale()=='en') { 

															$url = url('/user-active/' . $item->id);

														}else{

															$url = url('/ar/user-active/' . $item->id);

														}

													?>

                                        <a href="{{ $url }}" title="{{ __('admin-users.active_user') }}"

                                            class="btn btn-success btn-sm">

                                            <i class="material-icons" aria-hidden="true">

                                                arrow_upward

                                            </i>

                                        </a>

                                        @endif

                                        @endif

                                        <a href="{{ url('users/'.$item->id. '/show') }}"

                                            title="{{ __('admin-users.view_user') }}" class="btn btn-primary btn-sm">

                                            <i class="material-icons">

                                                remove_red_eye

                                            </i>

                                        </a>

                                        @if($item->id != Auth::id())

                                        <a href="{{ url('users/'.$item->id.'/edit') }}"

                                            title="{{ __('admin-users.edit_user')}}" class="btn btn-success btn-sm">

                                            <i class="material-icons">

                                                edit

                                            </i>

                                        </a>

                                        @endif

                                        @if($item->id != Auth::id())

                                        <form action="{{ url('/userDelete', $item->id) }}" method="POST" style="display:inline">
                                            @csrf
                                            @method('DELETE')
                                            
                                            <button type="submit" 
                                                    class="btn btn-danger btn-sm" 
                                                    title="{{ __('admin-sliders.delete_slider') }}" 
                                                    onclick="return confirm('{{ __('admin-sliders.confirm_delete') }}')">
                                                <i class="material-icons" aria-hidden="true">delete</i>
                                            </button>
                                        </form>
                                        
                                            
                                               


                                            @endif

                                            @if($type == 'partner')
                                                <a href="{{ url('users/'.$item->id. '/referralShow') }}"
                                                    title="{{ __('admin-users.view_user') }}" class="btn btn-info btn-sm">
                                                    <i class="material-icons">
                                                        people
                                                    </i>
                                                </a>
                                            @endif

                                    </div>

                                </div>

                            </div>

                        </div>

                        @endforeach

                        <div class="pagination-wrapper"> {!! $users->appends(['search' =>

                            Request::get('search')])->render() !!} </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection

@section('admin-additional-js')



@endsection