@extends('layouts.admin.master')
@section('title')
Reviews
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
                        <h4 class="card-title ">Reviews</h4>
                    </div>
                    <div class="card-body">

                    <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Trip</th>
                                        <th>Rating From</th>
                                        @role('admin')
                                        <th>Rating To</th>
                                        @endrole
                                        <th>Rating</th>
                                        <th>Review</th>
                                        @role('partner')
                                        <th>Actions</th>
                                        @endrole
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($reviews as $item)
                                    <tr>
                                        <td>{{ $item->tripBooking->trip->title }}</td>
                                        <td>{{ $item->ratingShipFrom->name }}</td>
                                        @role('admin')
                                        <td>{{ $item->ratingShipTo->name }}</td>
                                        @endrole
                                        <td>{{ $item->rating }}</td>
                                        <td>{{ $item->review }}</td>
                                        @role('partner')
                                        <td>
                                            @if(app()->getLocale() == 'ur')
                                            <form method="POST" action="{{ url('/ur/review-ship-delete/' . $item->id) }}" style="display:inline">
                                        @elseif(app()->getLocale() == 'ar')
                                            <form method="POST" action="{{ url('/ar/review-ship-delete/' . $item->id) }}" style="display:inline">
                                        @else
                                            <form method="POST" action="{{ url('/review-ship-delete/' . $item->id) }}" style="display:inline">
                                        @endif

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-danger btn-sm" title="Delete City" onclick="return confirm('Confirm delete?')">
                                                <i class="material-icons" aria-hidden="true">delete</i>
                                            </button>
                                        </form>

                                        </td>
                                        @endrole
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $reviews->appends(['search' => Request::get('search')])->render() !!} </div>
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