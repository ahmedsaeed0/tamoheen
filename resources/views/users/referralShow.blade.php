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
                            <h4 class="card-title ">Referrals User</h4>
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
                                        <th>Total Trip</th>
                                        <th>Completed Trip</th>
                                    </tr>
                                </thead>
                                <tbody>

                                @foreach($referralsUser as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->id }}</td>
                                        <td>
                                            {{ $item->name }}
                                        </td>
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