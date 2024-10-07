@extends('layouts.admin.master')
@section('title')
TripBooking {{ $tripbooking->id }}
@endsection
@section('admin-additional-css')
<link href="{{ asset('/qr-scanner/css/style.css') }}" rel="stylesheet">
<style type="text/css">
    /*#page-top{
        padding-top: 0px !important;
    }*/
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
                        <h4 class="card-title ">Shipment Booking {{ $tripbooking->id }}</h4><br>
                        
                    </div>
                    <div class="card-body">
                        <a  href="{{ url('/ship-trip-bookings') }}" class="btn btn-primary"> Back</a>
                        <div class="container" id="QR-Code">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <div class="navbar-form navbar-right">
                                        <div class="form-group">
                                            <select class="form-control" id="camera-select" style="padding-top: 2px"></select>
                                            {{-- <input id="image-url" type="text" class="form-control" placeholder="Image url"> --}}
                                            <button title="Decode Image" class="btn btn-dark btn-sm" id="decode-img" type="button" data-toggle="tooltip"><i class="fa fa-upload"></i></button>
                                            <button title="Image shoot" class="btn btn-info btn-sm disabled" id="grab-img" type="button" data-toggle="tooltip"><span class="fas fa-image"></span></button>
                                            <button title="Play" class="btn btn-success btn-sm" id="play" type="button" data-toggle="tooltip"><span class="fa fa-play"></span></button>
                                            <button title="Pause" class="btn btn-warning btn-sm" id="pause" type="button" data-toggle="tooltip"><span class="fa fa-pause"></span></button>
                                            <button title="Stop streams" class="btn btn-danger btn-sm" id="stop" type="button" data-toggle="tooltip"><span class="fa fa-stop"></span></button>
                                         </div>
                                    </div>
                                </div>
                                <div class="panel-body text-center row">
                                    <div class="col-md-6">
                                        <div class="well" style="position: relative;display: inline-block;">
                                            <canvas width="320" height="240" id="webcodecam-canvas"></canvas>
                                            <div class="scanner-laser laser-rightBottom" style="opacity: 0.5;"></div>
                                            <div class="scanner-laser laser-rightTop" style="opacity: 0.5;"></div>
                                            <div class="scanner-laser laser-leftBottom" style="opacity: 0.5;"></div>
                                            <div class="scanner-laser laser-leftTop" style="opacity: 0.5;"></div>
                                        </div>
                                        <div class="well" style="width: 100%;">
                                            <label id="zoom-value" width="100">Zoom: 2</label>
                                            <input id="zoom" onchange="Page.changeZoom();" type="range" min="10" max="30" value="20">
                                            <label id="brightness-value" width="100">Brightness: 0</label>
                                            <input id="brightness" onchange="Page.changeBrightness();" type="range" min="0" max="128" value="0">
                                            <label id="contrast-value" width="100">Contrast: 0</label>
                                            <input id="contrast" onchange="Page.changeContrast();" type="range" min="0" max="64" value="0">
                                            <label id="threshold-value" width="100">Threshold: 0</label>
                                            <input id="threshold" onchange="Page.changeThreshold();" type="range" min="0" max="512" value="0">
                                            <label id="sharpness-value" width="100">Sharpness: off</label>
                                            <input id="sharpness" onchange="Page.changeSharpness();" type="checkbox">
                                            <label id="grayscale-value" width="100">grayscale: off</label>
                                            <input id="grayscale" onchange="Page.changeGrayscale();" type="checkbox">
                                            <br>
                                            <label id="flipVertical-value" width="100">Flip Vertical: off</label>
                                            <input id="flipVertical" onchange="Page.changeVertical();" type="checkbox">
                                            <label id="flipHorizontal-value" width="100">Flip Horizontal: off</label>
                                            <input id="flipHorizontal" onchange="Page.changeHorizontal();" type="checkbox">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="thumbnail" id="result">
                                            <div class="well" style="overflow: hidden;">
                                                <img width="320" height="240" id="scanned-img" src="">
                                            </div>
                                            <div class="caption">
                                                <h3>Scanned result</h3>
                                                <p id="scanned-QR"></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row file-upload" style="display: none;">
                                    <div class="col-md-6 offset-3">
                                        <div class="card">
                                            <div class="card-body">
                                                @if(app()->getLocale() == 'ur')
                                                <form method="POST" action="/ur/ship-check-in-submit" class="form-horizontal" enctype="multipart/form-data" id="ship-check-in">
                                            @elseif(app()->getLocale() == 'ar')
                                                <form method="POST" action="/ar/ship-check-in-submit" class="form-horizontal" enctype="multipart/form-data" id="ship-check-in">
                                            @else
                                                <form method="POST" action="/ship-check-in-submit" class="form-horizontal" enctype="multipart/form-data" id="ship-check-in">
                                            @endif

                                                @csrf
                                                @method('POST')
                                                <input type="hidden" name="check_data" id="encrypt-data">
                                                
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
<script type="text/javascript" src="{{ asset('qr-scanner/js/filereader.js') }}"></script>
<script type="text/javascript" src="{{ asset('qr-scanner/js/qrcodelib.js') }}"></script>
<script type="text/javascript" src="{{ asset('qr-scanner/js/webcodecamjs.js') }}"></script>
<script type="text/javascript" src="{{ asset('qr-scanner/js/main.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $("#decode-img").hide();
        $("#grab-img").hide();
        var doCheck = true;
        var codeText;
        setInterval(function(){ 
            codeText = $("#encrypt-data").val();
            if ((codeText != '') && (doCheck)) {
                $("#ship-check-in").submit();
                doCheck = false;
            }
        }, 500); 
    });
</script>
@endsection