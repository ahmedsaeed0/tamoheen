@extends('layouts.admin.master')
@section('title')
Referrals
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
                            <h4 class="card-title ">Referrals</h4>
                        </div>
                    </div>
                    <div class="card-body">
                    <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>ID</th>
                                        <th>{{ __('admin-city.name') }}</th>
                                        <th>Code Owner</th>
                                        <th>New driver used code for registering</th>
                                        <th>New driver make trips</th>
                                        <th>New driver completed Trip</th>
                                    </tr>
                                </thead>
                                <tbody>

                                @foreach($users as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->id }}</td>
                                        <td>
                                            {{ $item->name }}
                                        </td>
                                        @if(!empty($item->referralcode))
                                            <td>{{ $item->referralcode }}</td>
                                        @else
                                            <td>N/A</td>
                                        @endif
                                        <td>{{ $item->TotalReferralUser }}</td>
                                        <td>{{ $item->TotalTrip }}</td>
                                        <td>{{ $item->TotalCompleteTrip }}</td>
                                    </tr>
                                @endforeach
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

