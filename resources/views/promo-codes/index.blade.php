@extends('layouts.admin.master')
@section('title')
PromoCodes
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
                            <h4 class="card-title ">{{ __('admin-promo-code.promo_codes') }}</h4>
                            <a  href="{{ url('/promo-codes/create') }}" class="btn btn-primary"> {{ __('admin-promo-code.add_promo_code') }}</a>
                        </div>
                        <div>
                            <a href=" {{url('/export-excel/promo-code')}}"><button class="btn btn-success btn-sm" data-target="trip">Export<div class="ripple-container"></div></button></a>
                        </div>
                    </div>
                    <div class="card-body">
                        @foreach($promo_codes as $item)
                            <div class="card">
								<div class="card-body">
									<div class="row">
										<div class="col-md-6">
                                            <p>{{ __('admin-promo-code.code') }} : {{ $item->code }}</p>
                                            <p>{{ __('admin-promo-code.type') }} : {{ $item->type }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p>{{ __('admin-promo-code.amount') }} : {{ ($item->amount != null) ? $item->amount : 0 }}</p>
                                            <p>{{ __('admin-promo-code.percent') }} : {{ ($item->percent != null) ? $item->percent : 0 }}</p>
                                        </div>
                                        <div class="col-md-12">
                                            <a href="{{ url('/promo-codes/' . $item->id . '/edit') }}" title="{{ __('admin-promo-code.edit_promo_code') }}" class="btn btn-success btn-sm">
                                                <i class="material-icons">
                                                    edit
                                                </i>
                                            </a>
                                            @if(app()->getLocale() == 'ur')
                                                    {!! Html::form(['method' => 'DELETE', 'url' => ['/ur/promo-codes', $item->id], 'style' => 'display:inline'])->open() !!}
                                                @elseif(app()->getLocale() == 'ar')
                                                    {!! Html::form('DELETE', url('/ar/promo-codes', $item->id), ['style' => 'display:inline'])->open() !!}
                                                @else
                                                    {!! Html::form('DELETE', url('promo-codes', $item->id), ['style' => 'display:inline'])->open() !!}
                                                @endif

                                               
                                                {!! Html::button('<i class="material-icons" aria-hidden="true">delete</i>')
                                                ->type('submit')
                                                ->class('btn btn-danger btn-sm')
                                                ->attribute('title', __('admin-promo-code.delete_promo_code'))
                                                ->attribute('onclick', 'return confirm("Confirm delete?")') !!}
                                              
                                                
                                           
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="pagination-wrapper"> {!! $promo_codes->appends(['search' => Request::get('search')])->render() !!} </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('admin-additional-js')

@endsection
