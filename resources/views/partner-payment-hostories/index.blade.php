@extends('layouts.admin.master')

@section('title')

Partnerpaymenthostories

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

                        <h4 class="card-title ">{{ __('admin-payment-history.partner_payment_history') }}</h4>

                        <a href="{{url('/export-excel/partner-payment-hostories')}}"><button class="btn btn-success btn-sm" data-target="trip">Export<div class="ripple-container"></div></button></a>

                    </div>

                    <div class="card-body">



                    <div class="table-responsive">

                            <table class="table table-bordered">

                                <thead>

                                    <tr>

                                       <!-- <th>#</th>

                                        <th>{{ __('admin-payment-history.partner') }}</th>-->

                                        <th>{{ __('admin-payment-history.partner_id') }}</th>

                                        <th>{{ __('admin-payment-history.partner_name') }}</th>

                                        @role('admin')

                                        <th>{{ __('admin-payment-history.price') }}</th>

                                        @endrole

                                        <th>{{ __('admin-payment-history.partner_price') }}</th>

                                        <th>{{ __('admin-payment-history.type') }}</th>



                                        <th>{{ __('admin-payment-history.trip_no') }}</th>

                                        <th>{{ __('admin-payment-history.trip_date_time') }}</th>

                                        <th>{{ __('admin-payment-history.trip_driver') }}</th>



                                        <th>{{ __('admin-payment-history.actions') }}</th>

                                    </tr>

                                </thead>

                                <tbody>

                                @foreach($partnerpaymenthostories as $item)

                                    <tr>

                                       <!-- <td>{{ $loop->iteration }}</td>

                                        -->
                                        <td>{{ $item->user_id }}</td>
                                        
                                        <td>{{ $item->users ? $item->users->name : ' User' }}</td>


                                        @role('admin')

                                        <td>{{ $item->price }}</td>

                                        @endrole

                                        <td>{{ $item->partner_price }}</td>

                                        <td>{{ $item->type }}</td>

                                        <td>

                                            {{ App\Http\Controllers\PartnerPaymentHostoriesController::getTripId($item->user_id) }}

                                        </td>

                                        <td>{{   !isset($item->trips->date)  ? '' : date("Y-m-d h:i:s A", strtotime($item->trips->date)) }}</td>

                                        <td>

                                            {{ !isset($item->trips->title) ? '' : $item->trips->title }}

                                        </td>

                                        <td>



                                            <a href="{{ url('/partner-payment-hostories/' . $item->id) }}" title="{{ __('admin-payment-history.view_partner_payment_history') }}" class="btn btn-info btn-sm">

                                                <i class="material-icons">

                                                    remove_red_eye

                                                </i>

                                            </a>



                                            {{-- <a href="{{ url('/partner-payment-hostories/' . $item->id . '/edit') }}" title="Edit PartnerPaymentHostory" class="btn btn-success btn-sm">

                                                <i class="material-icons">

                                                    edit

                                                </i>

                                            </a>



                                            {!! Form::open([

                                                'method'=>'DELETE',

                                                'url' => ['/partner-payment-hostories', $item->id],

                                                'style' => 'display:inline'

                                            ]) !!}

                                                {!! Form::button('<i class="material-icons" aria-hidden="true">delete</i>', array(

                                                        'type' => 'submit',

                                                        'class' => 'btn btn-danger btn-sm',

                                                        'title' => 'Delete PartnerPaymentHostory',

                                                        'onclick'=>'return confirm("Confirm delete?")'

                                                )) !!}

                                            {!! Form::close() !!} --}}

                                        </td>

                                    </tr>

                                @endforeach

                                </tbody>

                            </table>

                            <div class="pagination-wrapper"> {!! $partnerpaymenthostories->appends(['search' => Request::get('search')])->render() !!} </div>

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

