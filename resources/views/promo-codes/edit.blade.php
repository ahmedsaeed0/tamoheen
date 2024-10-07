@extends('layouts.admin.master')
@section('title')
Edit Promo Codes #{{$promocode->id}}
@endsection
@section('admin-additional-css')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/css/select2.min.css">
@endsection
@section('content')
<div class="content">
    @include('layouts.admin.include.alert')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title"> {{ __('admin-promo-code.edit_promo_code') }} #{{$promocode->id}}</h4>
                        <a  href="{{ url('/promo-codes') }}" class="btn btn-primary"> {{ __('admin-promo-code.back') }}</a>
                    </div>
                    <div class="card-body">

                        @if(app()->getLocale() == 'ur')
                            <form action="/ur/promo-codes/{{ $promocode->id }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                        @elseif(app()->getLocale() == 'ar')
                            <form action="/ar/promo-codes/{{ $promocode->id }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                        @else
                            <form action="/promo-codes/{{ $promocode->id }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                        @endif

                        @csrf
                        @method('PATCH')
                    
                        @include ('promo-codes.form', ['formMode' => 'edit'])
                    
                        {{-- <button type="submit" class="btn btn-primary">{{ __('admin-promo-code.update') }}</button> --}}
                    </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('admin-additional-js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();

        // التحقق من حالة الحقل عند تحميل الصفحة
        toggleFields($("#promo_code_select").val());

        // تحديث الحقول بناءً على الاختيار
        $("#promo_code_select").change(function() {
            toggleFields($(this).val());
        });

        function toggleFields(value) {
            if (value === "percent") {
                $("#percentage").show(500);
                $("#amount").hide(500).find("input").prop("required", false); // إزالة required من amount
                $("#percent").prop("required", true); // تعيين required لـ percent
            } else if (value === "amount") {
                $("#amount").show(500);
                $("#percentage").hide(500).find("input").prop("required", false); // إزالة required من percent
                $("#amount").prop("required", true); // تعيين required لـ amount
            }
        }
    });
</script>
@endsection
