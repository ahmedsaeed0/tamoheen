@extends('layouts.admin.master')
@section('title')
Create Promo Code
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
                        <h4 class="card-title ">{{ __('admin-promo-code.create_new_promo_code') }}</h4>
                        <a  href="{{ url('/promo-codes') }}" class="btn btn-primary"> {{ __('admin-promo-code.back') }}</a>
                    </div>
                    <div class="card-body">

                        <form method="POST" action="{{ app()->getLocale() == 'ur' ? url('/ur/promo-codes') : (app()->getLocale() == 'ar' ? url('/ar/promo-codes') : url('/promo-codes')) }}" class="form-horizontal" enctype="multipart/form-data">
                            @csrf
                        
                            @include('promo-codes.form', ['formMode' => 'create'])
                        
                            {{-- <button type="submit" class="btn btn-primary">Submit</button>   --}}
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
<script type="text/javascript">
    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
    });

    document.getElementById("amount").style.display="none";

    var promo_code_select = document.getElementById("promo_code_select");
    $(promo_code_select).change(function(){
        var select_promo_code_value= promo_code_select.options[promo_code_select.selectedIndex].value;
        if(select_promo_code_value == "percent"){
            $("#percentage").show(500);
            $("#amount").hide(500);
        }else if(select_promo_code_value == "amount"){
            $("#amount").show(500);
            $("#percentage").hide(500);
        }
    });
</script>
@endsection
