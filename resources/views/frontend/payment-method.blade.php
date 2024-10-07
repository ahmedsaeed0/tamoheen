@extends('layouts.front.master')

@section('title')
    Trip Book
@endsection

@section('front-additional-css')
    <!-- Additional CSS -->
@endsection

@section('content')
    @include('layouts.front.include.header1')

    <main id="content" class="bg-gray space-2">
        <div class="container">
            <div class="row">
                
                <div class="col-lg-6 col-xl-6">
                    <div class="mb-5 shadow-soft bg-white rounded-sm">
                        <div class="py-3 px-4 px-xl-12 border-bottom">
                            <h2 class="text-center">@lang('payment-method.payment_method')</h2>
                            @if(session()->has('success'))
                                <span class="text-success text-center">{{ Session::get('success') }}</span>
                            @endif
                            @if(session()->has('error'))
                                <span class="text-danger text-center">{{ Session::get('error') }}</span>
                            @endif
                        </div>
                        <div class="pt-4 pb-5 px-5">
                            <h5 id="scroll-description" class="font-size-21 font-weight-bold text-dark mb-4">
                                @lang('payment-method.new_payment_method')
                            </h5>
                            
                            @if(app()->getLocale() == 'ur')
                                <form class="js-validate" action="{{ url('ur/user-add-payment-method') }}" method="POST">
                            @elseif(app()->getLocale() == 'ar')
                                <form class="js-validate" action="{{ url('ar/user-add-payment-method') }}" method="POST">
                            @else
                                <form class="js-validate" action="{{ url('user-add-payment-method') }}" method="POST">
                            @endif
                                @csrf
                                <div class="row">
                                    
                                    <div class="col-sm-12 mb-4">
                                        <div class="js-form-message">
                                            <label class="form-label">
                                                @lang('payment-method.name')<span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" name="payment_method_name" placeholder="@lang('payment-method.name')" aria-label="Name" required
                                                data-msg="Required."
                                                data-error-class="u-has-error"
                                                data-success-class="u-has-success">
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-12 mb-4">
                                        <div class="js-form-message">
                                            <label class="form-label">
                                                @lang('payment-method.details')<span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" name="payment_method_details" placeholder="@lang('payment-method.details')" aria-label="Name" required
                                                data-msg="Required."
                                                data-error-class="u-has-error"
                                                data-success-class="u-has-success">
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 align-self-end">
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary btn-wide rounded-sm transition-3d-hover font-size-16 font-weight-bold py-3">@lang('payment-method.create')</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6 col-xl-6">
                    <div class="mb-5 shadow-soft bg-white rounded-sm">
                        <div class="py-3 px-4 px-xl-12 border-bottom">
                            <h2 class="text-center">Payment Method List</h2>
                        </div>
                        <div class="pt-4 pb-5 px-5">
                            
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if($payment_method!=null)
                                    @foreach ($payment_method as $method)
                                        <tr>
                                            <td>{{ $method->name }}</td>
                                            <td>{{ $method->details }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                            
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </main>
@endsection

@section('front-additional-js')
    <!-- Additional JS -->
@endsection