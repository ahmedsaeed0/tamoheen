@extends('layouts.admin.master')
@section('title')
Edit TripBooking #{{ $tripbooking->id }}
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
                        <h4 class="card-title ">{{ __('admin-trip-booking.edit_trip_booking')}}#{{ $tripbooking->id }}</h4>
                        <a  href="{{ url('/trip-bookings') }}" class="btn btn-primary"> {{ __('admin-trip-booking.back')}}</a>
                    </div>
                    <div class="card-body">
                        <form action="/trip-bookings/{{ $tripbooking->id }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                        
                            @include('trip-bookings.form', ['formMode' => 'edit'])
                        
                            {{-- <div class="form-group">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div> --}}
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
