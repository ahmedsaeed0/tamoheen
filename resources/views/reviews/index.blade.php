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
                    <div class="card-header card-header-primary d-flex justify-content-between align-items-center">
                        <h4 class="card-title ">{{ __('admin-trip-review.reviews')}}</h4>
                        <a href="{{url('/export-excel/reviews')}}"><button class="btn btn-success btn-sm" data-target="trip">Export<div class="ripple-container"></div></button></a>
                    </div>
                    <div class="card-body">
                        @foreach($reviews as $item)
                        
                            <?php
                                $sql = "SELECT * FROM trip_bookings tb  LEFT JOIN trips t ON t.id = tb.trip_id WHERE tb.id = ".$item->trip_booking_id;
                                $results = DB::select($sql);
                                Lang::locale();
                            ?>
                            @if($results)
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p>{{ __('admin-trip-review.trip')}} : 

                                                <?php  
                                                    if (Lang::locale()=='en') { 
                                                        echo $results[0]->title;
                                                    }else{
                                                        echo $results[0]->title_arabic;
                                                    }                                                
                                                ?> 
                                            </p>
                                            
                                        </div>
                                        <div class="col-md-4">
                                            <p>{{ __('admin-trip-review.rating_from')}} : {{ $item->ratingFrom->name }}

                                            </p>
                                            @role('admin')
                                            <p>{{ __('admin-trip-review.rating_to')}} : {{ $item->ratingTo->name }}</p>
                                            @endrole
                                                                                  
                                        </div>
                                        <div class="col-md-4">
                                            <p>{{ __('admin-trip-review.rating')}} : {{ $item->rating }}</p>
                                            <p>{{ __('admin-trip-review.review')}} : {{ $item->review }}</p>                                         
                                        </div>
                                        <div class="col-md-12">
                                        @role('admin')
                                        <p>
                                            @if(app()->getLocale() == 'ur')
                                                <form method="POST" action="{{ url('/ur/reviews', $item->id) }}" style="display:inline">
                                                    @csrf
                                                    @method('DELETE')
                                            @elseif(app()->getLocale() == 'ar')
                                                <form method="POST" action="{{ url('/ar/reviews', $item->id) }}" style="display:inline">
                                                    @csrf
                                                    @method('DELETE')
                                            @else
                                                <form method="POST" action="{{ url('/reviews', $item->id) }}" style="display:inline">
                                                    @csrf
                                                    @method('DELETE')
                                            @endif
                                                    <button type="submit" class="btn btn-danger btn-sm" title="{{ __('admin-trip-review.delete_city') }}" onclick="return confirm('Confirm delete?')">
                                                        <i class="material-icons" aria-hidden="true">delete</i>
                                                    </button>
                                                </form>

                                                </p>
                                        @endrole
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('admin-additional-js')

@endsection
