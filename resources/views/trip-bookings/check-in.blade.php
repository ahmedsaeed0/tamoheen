@extends('layouts.admin.master')
@section('title')
TripBooking {{ $tripbooking->id }}
@endsection
@section('admin-additional-css')
<link href="{{ asset('qr-scanner/css/style.css') }}" rel="stylesheet">
<style type="text/css">
    /*#page-top{
        padding-top: 0px !important;
    }*/
    .card .table tr:first-child td {
        border-top: 1px solid #ddd;
    }
    .video-back{
        width: 100%;
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
                        <h4 class="card-title ">{{ __('admin-trip-booking.trip_bookings')}} {{ $tripbooking->id }}</h4><br>

                    </div>
                    <div class="card-body">
                        <a  href="{{ url('/trip-bookings') }}" class="btn btn-primary"> {{ __('admin-trip-booking.back')}}</a>
                        <div class="container" id="QR-Code">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <div class="navbar-form navbar-right">
                                        <div class="form-group">
                                            {{-- <video id="preview"></video> --}}
                                            <video id="preview" class="video-back" playsinline></video>
                                         </div>
                                    </div>
                                </div>

                                <div class="row file-upload" style="display: none;">
                                    <div class="col-md-6 offset-3">
                                        <div class="card">
                                            <div class="card-body">
                                                <form action="{{ app()->getLocale() == 'ur' ? '/ur/check-in-submit' : (app()->getLocale() == 'ar' ? '/ar/check-in-submit' : '/check-in-submit') }}" 
                                                    method="POST" 
                                                    class="form-horizontal" 
                                                    enctype="multipart/form-data" 
                                                    id="check-in">
                                                  @csrf
                                                  <input type="hidden" name="encrypt_data" id="encrypt-data">
                                                  <input type="hidden" name="request_booking_id" value="{{ $tripbooking->id }}">
                                                  
                                                  {{-- <div class="form-group">
                                                      <button type="submit" class="btn btn-primary btn-block">Submit</button>
                                                  </div> --}}
                                              </form>
                                              
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br/>
                            </div>
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
    let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
    scanner.addListener('scan', function (content) {
      $("#encrypt-data").val(content);
    });
    Instascan.Camera.getCameras().then(function (cameras) {
    if (cameras.length > 2) {
        scanner.start(cameras[2]);
    }else if(cameras.length > 1){
        scanner.start(cameras[1]);
    } else {
        console.error('No cameras found.');
    }
    }).catch(function (e) {
        alert(e);
    //   console.error(e);
    });
  
    $(document).ready(function(){
        $("#decode-img").hide();
        $("#grab-img").hide();
        var doCheck = true;
        var codeText;
        setInterval(function(){
            codeText = $("#encrypt-data").val();
            if ((codeText != '') && (doCheck)) {
                $("#check-in").submit();
                doCheck = false;
            }
        }, 500);
    });
</script>
@endsection
