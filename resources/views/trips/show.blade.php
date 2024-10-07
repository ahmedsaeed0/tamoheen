@extends('layouts.admin.master')
@section('title')
Trip {{ $trip->id }}
@endsection
@section('admin-additional-css')
<style type="text/css">
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
                        <h4 class="card-title ">Trip {{ $trip->id }}</h4>
                        <a  href="{{ url('/trips') }}" class="btn btn-primary"> {{ __('admin-trip.back')}}</a>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>{{ __('admin-trip.id')}}</th>
                                        <td>{{ $trip->id }}</td>
                                    </tr>
                                    <tr>
                                        <th> {{ __('admin-trip.user')}} </th>
                                        <td> {{ $trip->user->name }} </td>
                                    </tr>
                                    <tr>
                                        <th> {{ __('admin-trip.title')}} </th>
                                        <td> {{ $trip->title }} </td>
                                    </tr>
                                    <tr>
                                        <th> {{ __('admin-trip.title_arabic')}} </th>
                                        <td> {{ $trip->title_arabic }} </td>
                                    </tr>
                                    {{-- <tr>
                                        <th> Title Urdu </th>
                                        <td> {{ $trip->title_urdu }} </td>
                                    </tr> --}}
                                    <tr>
                                        <th> {{ __('admin-trip.from')}} </th>
                                        <td> {{ $trip->cityFrom ? $trip->cityFrom->name : 'N/A' }} </td>

                                    </tr>
                                    <tr>
                                        <th> {{ __('admin-trip.to')}} </th>
                                        <td> {{ $trip->cityTo->name  ??  ''}} </td>
                                    </tr>
                                    <tr>
                                        <th> {{ __('admin-trip.car')}} </th>
                                        <td> {{ $trip->cars->name }} </td>
                                    </tr>
                                    @isset($trip->feature_id)
                                    <tr>
                                        <th> {{ __('admin-trip.feature')}} </th>
                                        <td> {{ $trip->feature->name }} </td>
                                    </tr>
                                    @endisset
                                    <tr>
                                        <th> {{ __('admin-trip.description')}} </th>
                                        <td> {{ $trip->description }} </td>
                                    </tr>
                                    <tr>
                                        <th> {{ __('admin-trip.description_arabic')}} </th>
                                        <td> {{ $trip->description_arabic }} </td>
                                    </tr>
                                    {{-- <tr>
                                        <th> Description Urdu </th>
                                        <td> {{ $trip->description_urdu }} </td>
                                    </tr> --}}
                                    @if($trip->type == 1)
                                    <tr>
                                        <th> {{ __('admin-trip.number_of_person')}} </th>
                                        <td> {{ $trip->number_of_person }} </td>
                                    </tr>
                                    @else
                                        <tr>
                                        <th> {{ __('admin-trip.number_of_bag')}} </th>
                                        <td> {{ $trip->number_of_bag }} </td>
                                    </tr>
                                    @endif
                                    @if($trip->type == 1)
                                    <tr>
                                        <th> {{ __('admin-trip.price_per_person')}}  </th>
                                        <td> {{ $trip->price_per_person }} </td>
                                    </tr>
                                    @else
                                        <tr>
                                        <th> {{ __('admin-trip.price_per_bag')}} </th>
                                        <td> {{ $trip->price_per_bag }} </td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <th> {{ __('admin-trip.discount')}} </th>
                                        <td> {{ $trip->discount }} </td>
                                    </tr>
                                    <tr>
                                        <th> {{ __('admin-trip.start_point')}} </th>
                                        <td> {{ $trip->start_point }} </td>
                                    </tr>
                                    <tr>
                                        <th> {{ __('admin-trip.end_point')}}  </th>
                                        <td> {{ $trip->end_point }} </td>
                                    </tr>
                                    <tr>
                                        <th> {{ __('admin-trip.date')}}</th>
                                        <td>
                                            {{ Carbon\Carbon::parse($trip->date)->format('d-m-Y H:i:s') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th> {{ __('admin-trip.drop_off_time')}}</th>
                                        <td>
                                            {{ Carbon\Carbon::parse($trip->drop_off_time)->format('d-m-Y H:i:s') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('admin-trip.type')}}</th>
                                        <td>
                                            @if($trip->type == 1)
                                                <span class="text-primary">{{ __('admin-trip.ride')}}</span>
                                            @else
                                                <span class="text-primary">{{ __('admin-trip.shipment')}}</span>
                                            @endif
                                        </td>
                                    </tr>

                                    @if($trip->type == 2)
                                        @if($trip->tripProductTypes != null)
                                            <tr>
                                                <th> {{ __('admin-trip.product_type')}} </th>
                                                <td>
                                                    @foreach($trip->tripProductTypes as $producttype)
                                                        <span class="badge badge-success">{{ $producttype->name }}</span>
                                                    @endforeach
                                                </td>
                                            </tr>
                                        @endif
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
