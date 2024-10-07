@extends('layouts.admin.master')
@section('title')
ShipmentBooking
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
                        <h4 class="card-title ">ShipmentBooking</h4>
                    </div>
                    <div class="card-body">

                    <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>User</th>
                                        <th>Trip</th>
                                        @role('admin')
                                        <th>User Price</th>
                                        @endrole
                                        <th>Partner Price</th>
                                        <th>Number Of Bag</th>
                                        <th>Is Payment Complete?</th>
                                        <th>Booking Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($tripbookings as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->user->name }}</td>
                                        <td>{{ $item->trip->title }}</td>
                                        @role('admin')
                                        <td>{{ $item->price }}</td>
                                        @endrole
                                        <td>{{ $item->partner_price }}</td>
                                        <td>{{ $item->number_of_bag }}</td>
                                        <td>
                                            @if($item->is_payment_complete == 1)
                                                <span class="badge badge-success">Complete</span>
                                            @else
                                                <span class="badge badge-danger">Incomplete</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($item->status == 1)
                                                <span class="badge badge-success">Success</span>
                                            @elseif($item->status == 2)
                                                <span class="badge badge-primary">Checked In</span>
                                            @elseif($item->status == 0)
                                                <span class="badge badge-info">Cancel</span>
                                            @elseif($item->status == 3)
                                                <span class="badge badge-info">Checked Out</span>
                                            @else
                                                <span class="badge badge-success">Completed</span>
                                            @endif
                                        </td>
                                        <td>

                                            <a href="{{ url('/ship-trip-bookings/' . $item->id) }}" title="View TripBooking" class="btn btn-info btn-sm">
                                                <i class="material-icons">
                                                    remove_red_eye
                                                </i>
                                            </a>
                                            @role('partner')
                                            @if($item->is_payment_complete == 1 && $item->check_in == null)
                                            <a href="{{ url('/ship-check-in/' . $item->id) }}" title="Check In TripBooking" class="btn btn-info btn-sm">
                                                Check In
                                            </a>
                                            @endif

                                            @if($item->is_payment_complete == 1 && $item->check_in != null && $item->check_out == null)
                                            <a href="{{ url('/ship-check-out/' . $item->id) }}" title="Check Out TripBooking" class="btn btn-info btn-sm">
                                                Check Out
                                            </a>
                                            @endif

                                            @if($item->is_payment_complete == 1 && $item->status == 3)
                                            <a href="{{ url('ship-booking-complete/' . $item->id) }}" title="Check Out TripBooking" class="btn btn-info btn-sm">
                                                Trip Complete
                                            </a>
                                            @endif
                                            @if(app()->getLocale() == 'ur')
                                            <form method="POST" action="/ur/ship-trip-bookings/{{ $item->id }}" style="display:inline">
                                                @csrf
                                                @method('DELETE')
                                        @elseif(app()->getLocale() == 'ar')
                                            <form method="POST" action="/ar/ship-trip-bookings/{{ $item->id }}" style="display:inline">
                                                @csrf
                                                @method('DELETE')
                                        @else
                                            <form method="POST" action="/ship-trip-bookings/{{ $item->id }}" style="display:inline">
                                                @csrf
                                                @method('DELETE')
                                        @endif

                                            <button type="submit" class="btn btn-danger btn-sm" title="Delete TripBooking" onclick="return confirm('Confirm delete?')">
                                                <i class="material-icons" aria-hidden="true">delete</i>
                                            </button>
                                        </form>

                                            @endrole
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $tripbookings->appends(['search' => Request::get('search')])->render() !!} </div>
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