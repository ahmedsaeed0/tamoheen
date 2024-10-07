@extends('layouts.admin.master')
@section('title')
Trips
@endsection
@section('admin-additional-css')
<style>
    .table-condensed {
        width: 100%;
        opacity: 10;
        background: #fff;
    }

    .datepicker-form-group {
        position: relative !important;
    }

    .datepicker-form-group .bootstrap-datetimepicker-widget {
        padding: 0 !important;
        z-index: 100 !important;
        position: absolute !important;
        border: 1px solid #dadce0;
        box-shadow: 0 7px 20px rgba(0,0,0,0.1);
    }

    .datepicker-form-group .bootstrap-datetimepicker-widget > ul {
        background-color: white !important;
    }
</style>
<link href="{{asset('admin/assets/css/bootstrap-datetimepicker-2.min.css')}}" rel="stylesheet" />
@endsection
@section('content')
<div class="content">
    @include('layouts.admin.include.alert')
    @include('layouts.admin.include.trip-error')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">{{ __('admin-trip.trip')}}</h4>
                        @role('partner')
                        <a  href="{{ url('/trips/create') }}" class="btn btn-primary"> {{ __('admin-trip.add_new_trips')}}</a>
                        @endrole
                    </div>
                    <div class="card-body">

                    <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <!--<th>#</th>
                                        <th>{{ __('admin-trip.title')}}</th>
                                        <th>{{ __('admin-trip.from')}}</th>-->
                                        <th>{{ __('admin-trip.date')}}</th>
                                       <!--<th>{{ __('admin-trip.drop_off_time')}}</th>
                                        <th>{{ __('admin-trip.start_point')}}</th>
                                        <th>{{ __('admin-trip.end_point')}}</th>-->
                                        <th>{{ __('admin-trip.actions')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($trips as $item)
                                    <tr>
                                       <!-- <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->title }}</td>
                                        <td>{{ $item->from }}</td>-->
                                        <td>{{ Carbon\Carbon::parse($item->date)->format('d-m-Y H:i') }}</td>
                                      <!--  <td>{{ Carbon\Carbon::parse($item->drop_off_time)->format('d-m-Y H:i') }}</td>
                                        <td>{{ $item->start_point }}</td>
                                        <td>{{ $item->end_point }}</td>-->
                                        <td>

                                            <a href="{{ url('/trips/' . $item->id) }}" title="View Trip" class="btn btn-info btn-sm">
                                                <i class="material-icons">
                                                    remove_red_eye
                                                </i>
                                            </a>

                                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" title="{{ __('admin-trip.trip_copy')}}" data-target="#trip-copy-{{ $item->id }}">
                                                <i class="material-icons">
                                                    content_copy
                                                </i>
                                            </button>

                                            <div class="modal fade" id="trip-copy-{{ $item->id }}">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <form action="{{ route('trip.copy') }}" method="post">
                                                            @csrf
                                                            <input type="hidden" name="trip_id" value="{{ $item->id }}">
                                                            <!-- Modal Header -->
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">{{ __('admin-trip.trip_copy')}}</h4>
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>

                                                            <!-- Modal body -->
                                                            <div class="modal-body">
                                                                <div class="form-group {{ $errors->has('pickup_date') ? 'has-error' : ''}}">
                                                                    {!! Form::label('pickup_date', 'Pickup Date', ['class' => 'control-label']) !!}
                                                                    {!! Form::text('pickup_date', null, ('' == 'required') ? ['class' => 'form-control hijri-date-input datetimepicker', 'required' => 'required', 'id' => 'hijri-date-input'] : ['class' => 'form-control datetimepicker hijri-date-input', 'id' => 'hijri-date-input']) !!}
                                                                    {!! $errors->first('pickup_date', '<p class="help-block">:message</p>') !!}
                                                                </div>

                                                                <div class="form-group {{ $errors->has('drop_off_date') ? 'has-error' : ''}}">
                                                                    {!! Form::label('drop_off_date', 'Dropoff Date', ['class' => 'control-label']) !!}
                                                                    {!! Form::text('drop_off_date', null, ('' == 'required') ? ['class' => 'form-control hijri-drop-date-input datetimepicker', 'required' => 'required', 'id' => 'hijri-drop-date-input'] : ['class' => 'form-control datetimepicker hijri-drop-date-input', 'id' => 'hijri-drop-date-input']) !!}
                                                                    {!! $errors->first('drop_off_date', '<p class="help-block">:message</p>') !!}
                                                                </div>
                                                            </div>

                                                            <!-- Modal footer -->
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-success">{{ __('admin-trip.save')}}</button>
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('admin-trip.close')}}</button>
                                                            </div>
                                                        </form>

                                                    </div>
                                                </div>
                                            </div>

                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" title="Trip Discount" data-target="#trip-discount-{{ $item->id }}">
                                                <i class="material-icons">
                                                    discount
                                                </i>
                                            </button>

                                            <div class="modal fade" id="trip-discount-{{ $item->id }}">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <form action="{{ route('trip.discount') }}" method="post">
                                                            @csrf
                                                            <input type="hidden" name="trip_id" value="{{ $item->id }}">
                                                            <!-- Modal Header -->
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Trip Discount</h4>
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>

                                                            <!-- Modal body -->
                                                            <div class="modal-body">
                                                                <div class="form-group {{ $errors->has('discount') ? 'has-error' : ''}}">
                                                                    {!! Form::label('discount', 'Discount', ['class' => 'control-label']) !!}
                                                                    {!! Form::number('discount', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
                                                                    {!! $errors->first('discount', '<p class="help-block">:message</p>') !!}
                                                                </div>
                                                            </div>

                                                            <!-- Modal footer -->
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-success">Save</button>
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            </div>
                                                        </form>

                                                    </div>
                                                </div>
                                            </div>



                                            @role('partner')
                                            @if($item->status != 2 && $item->status != 3)
                                                <a href="{{ url('/trip-cancel/' . $item->id) }}" title="Cancel Trip" class="btn btn-danger btn-sm">
                                                    <i class="material-icons">
                                                        close
                                                    </i>
                                                </a>
                                            @endif
                                            @if($item->status != 2 && $item->status != 3)
                                            <a href="{{ url('/trip-complete/' . $item->id) }}" title="Complete Trip" class="btn btn-info btn-sm">
                                                <i class="material-icons">
                                                    check_circle
                                                </i>
                                            </a>
                                            @endif
                                            {{-- <a href="{{ url('/trips/' . $item->id . '/edit') }}" title="Edit Trip" class="btn btn-success btn-sm">
                                                <i class="material-icons">
                                                    edit
                                                </i>
                                            </a> --}}
                                            @if($item->tripBookings()->count() == 0)
                                            @if(app()->getLocale() == 'ur')
                                                {!! Form::open([
                                                    'method'=>'DELETE',
                                                    'url' => ['/ur/trips', $item->id],
                                                    'style' => 'display:inline'
                                                ]) !!}
                                            @elseif(app()->getLocale() == 'ar')
                                                {!! Form::open([
                                                    'method'=>'DELETE',
                                                    'url' => ['/ar/trips', $item->id],
                                                    'style' => 'display:inline'
                                                ]) !!}
                                            @else
                                                {!! Form::open([
                                                    'method'=>'DELETE',
                                                    'url' => ['/trips', $item->id],
                                                    'style' => 'display:inline'
                                                ]) !!}
                                            @endif
                                                {!! Form::button('<i class="material-icons" aria-hidden="true">delete</i>', array(
                                                        'type' => 'submit',
                                                        'class' => 'btn btn-danger btn-sm',
                                                        'title' => 'Delete Trip',
                                                        'onclick'=>'return confirm("Confirm delete?")'
                                                )) !!}
                                            {!! Form::close() !!}
                                            @endif
                                            @endrole
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $trips->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('admin-additional-js')
<script type="text/javascript">
    $(document).ready(function() {
        $('#hijri-date-input').datetimepicker({
            "allowInputToggle": true,
            "showClose": true,
            "showClear": true,
            "showTodayButton": true,
            "format": "MM/DD/YYYY hh:mm:ss",
            "keepOpen": false,
        });

        $(".hijri-date-input").click(function(){
            $(".bootstrap-datetimepicker-widget").removeClass("dropdown-menu");
        });

        $('#hijri-drop-date-input').datetimepicker({
            "allowInputToggle": true,
            "showClose": true,
            "showClear": true,
            "showTodayButton": true,
            "format": "MM/DD/YYYY hh:mm:ss",
            "keepOpen": false,
        });

        $(".hijri-drop-date-input").click(function(){
            $(".bootstrap-datetimepicker-widget").removeClass("dropdown-menu");
        });
    });
</script>
@endsection
