@extends('layouts.front.master')
@section('title')
Trip List
@endsection
@section('front-additional-css')
<style type="text/css">
    /*body {
      background-color:  #eee;
    }*/
    .title {
     
        margin-bottom: 50px;
        text-transform: uppercase;
    }

    .card-block {
        font-size: 1em;
        position: relative;
        margin: 0;
        padding: 1em;
        border: none;
        border-top: 1px solid rgba(34, 36, 38, .1);
        box-shadow: none;
         
    }
    .card {
        font-size: 1em;
        overflow: hidden;
        padding: 5;
        border: none;
        border-radius: .28571429rem;
        box-shadow: 0 1px 3px 0 #d4d4d5, 0 0 0 1px #d4d4d5;
        margin-top:20px;
    }

    .carousel-indicators li {
        border-radius: 12px;
        width: 12px;
        height: 12px;
        background-color: #404040;
    }
    .carousel-indicators li {
        border-radius: 12px;
        width: 12px;
        height: 12px;
        background-color: #404040;
    }
    .carousel-indicators .active {
        background-color: white;
        max-width: 12px;
        margin: 0 3px;
        height: 12px;
    }
    .carousel-control-prev-icon {
     background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%23fff' viewBox='0 0 8 8'%3E%3Cpath d='M5.25 0l-4 4 4 4 1.5-1.5-2.5-2.5 2.5-2.5-1.5-1.5z'/%3E%3C/svg%3E") !important;
    }

    .carousel-control-next-icon {
      background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%23fff' viewBox='0 0 8 8'%3E%3Cpath d='M2.75 0l-1.5 1.5 2.5 2.5-2.5 2.5 1.5 1.5 4-4-4-4z'/%3E%3C/svg%3E") !important;
    }
      

    .btn {
      margin-top: auto;
    }

    .card-block p{
        line-height: 1;
    }
</style>
@endsection
@section('content')
@include('layouts.front.include.header1')
<main id="content" role="main">
    <h3>Trip List</h3>
</main>

<!-- The Modal -->
<div class="modal" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header mx-auto d-block">
          <h4 class="modal-title">Select Your Trip</h4>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
            <div class="container">
                <a href="">
                <div class="card">
                    <div class="row">
                        <div class="col-sm-5">
                            <img class="d-block w-100" src="{{ asset('front/assets/images/hijab.png') }}" alt="">
                        </div>
                        <div class="col-sm-7">
                            <div class="card-block">
                                <!--           <h4 class="card-title">Small card</h4> -->
                                <h3>Family Trip</h3>
                                <p>An adult male must accompany you</p>
                                
                            </div>
                        </div>
             
                    </div>
                </div>
                </a>
                <a href="">
                <div class="card">
                    <div class="row">
                        <div class="col-sm-5">
                            <img class="d-block w-100" src="{{ asset('front/assets/images/male.jpg') }}" alt="">
                        </div>
                        <div class="col-sm-7">
                            <div class="card-block">
                                <!--           <h4 class="card-title">Small card</h4> -->
                                <h3>Individuals Trip</h3>
                                <p>An adult male must accompany you</p>
                                
                            </div>
                        </div>
             
                    </div>
                </div>
                </a>
            </div>
        </div>
        
        <!-- Modal footer -->
        {{-- <div class="modal-footer">
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
        </div> --}}
        
      </div>
    </div>
</div>
@endsection
@section('front-additional-js')
<script type="text/javascript">
    $(window).on('load',function(){
        $('#myModal').modal('show');
    });
</script>
@endsection