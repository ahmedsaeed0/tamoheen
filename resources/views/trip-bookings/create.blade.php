@extends('layouts.admin.master')
@section('title')
Create New TripBooking
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
                        <h4 class="card-title ">{{ __('admin-trip-booking.create_new_trip_booking')}}</h4>
                        <a  href="{{ url('/trip-bookings') }}" class="btn btn-primary"> {{ __('admin-trip-booking.back')}}</a>
                    </div>
                    <div class="card-body">
                        <form action="/trip-bookings" method="POST" class="form-horizontal" enctype="multipart/form-data">
                            @csrf
                        
                            @include('trip-bookings.form', ['formMode' => 'create'])
                        
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
