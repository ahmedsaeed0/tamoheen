@extends('layouts.admin.master')
@section('title')
Cars
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
                        <h4 class="card-title ">{{ __('admin-car.car_list') }}</h4>
                        <a  href="{{ url('/cars/create') }}" class="btn btn-primary"> {{ __('admin-car.add_new_car') }}</a>
                    </div>
                  
                        {{ __('admin-car.id') }}
                        </div>
                         <div class="newlistitem" >
                        {{ __('admin-car.model') }} 
                        </div>
                         <div class="newlistitem" >
                        {{ __('admin-car.capacity_of_person') }}
                        </div>
                         <div class="newlistitem" >
                        {{ __('admin-car.capacity_of_bag') }}
                        </div>
                         <div class="newlistitem" >
                        {{ __('admin-car.actions') }}
                        </div>
                    </div>-->
                    
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="text-primary">
                                   <!-- <th>{{ __('admin-car.id') }}</th>-->
                                    <th>{{ __('admin-car.model') }}</th>
                                  <!--  <th>{{ __('admin-car.capacity_of_person') }}</th>-->
                                   <!-- <th>{{ __('admin-car.capacity_of_bag') }}</th>-->
                                    <th>{{ __('admin-car.actions') }}</th>
                                </thead>
                                <tbody>
                                    @foreach($cars as $item)
                                    <tr>
                                        <!--<td>{{ $loop->iteration }}</td>-->
                                        <td>{{ $item->name }}</td>
                                        <!--<td>{{ $item->capacity_of_person }}</td>-->
                                        <!--<td>{{ $item->capacity_of_bag }}</td>-->
                                        
                                        <td>
                                            <a href="{{ url('cars/'.$item->id.'/edit') }}" title="{{ __('admin-car.edit_car') }}" class="btn btn-success btn-sm">
                                                <i class="material-icons">edit</i>
                                            </a>
                                            <a href="{{ url('cars/'.$item->id) }}" title="{{ __('admin-car.view_car') }}" class="btn btn-info btn-sm">
                                                <i class="material-icons">remove_red_eye</i>
                                            </a>
                                        
                                            @if(app()->getLocale() == 'ur')
                                                {!! html()->form('DELETE', '/ur/cars/'.$item->id, ['style' => 'display:inline'])->open() !!}
                                            @elseif(app()->getLocale() == 'ar')
                                                {!! html()->form('DELETE', '/ar/cars/'.$item->id, ['style' => 'display:inline'])->open() !!}
                                            @else
                                                {!! html()->form('DELETE', '/cars/'.$item->id, ['style' => 'display:inline'])->open() !!}
                                            @endif
                                        
                                            <form action="{{ url('cars/'.$item->id) }}" method="POST" style="display:inline">
                                                @csrf
                                                @method('DELETE')
                                                
                                                <button type="submit" class="btn btn-danger btn-sm" title="{{ __('admin-car.delete_car') }}" onclick="return confirm('Confirm delete?')">
                                                    <i class="material-icons" aria-hidden="true">delete</i>
                                                </button>
                                            </form>
                                            
                                        
                                       
                                        
                                        
                                        {!! html()->form()->close() !!}
                                        </td>
                                        
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $cars->appends(['search' => Request::get('search')])->render() !!} </div>
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
