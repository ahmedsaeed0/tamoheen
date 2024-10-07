@extends('layouts.front.master')

@section('title')

Trip List

@endsection

@section('front-additional-css')

<style type="text/css">

    

    /* .title {



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





    .btn {

      margin-top: auto;

    }



    .card-block p{

        line-height: 1;

    }

    .trip-banner{

        width: 100%;

        object-fit: cover;

        height: 600px;

    }

    .gallery-slider {

	    position: relative;

	    overflow: hidden;

	    background-color: #e6e6e6;

    }



    .active-date{

        background-color: green;

        color: white;

     }



     .deactive-date{

        background-color: blue;

        color: white;

     }

     .bootstrap-select > button{

         display: flex

    }



    @media screen and (max-width: 400px) {

        .date-bedge .badge{

        font-size: 0.5rem!important

    } */

/* } */.gallery-slider__images img {
    width: 100%;
    height: auto;
    object-fit: cover;
    border-radius: 8px;
    transition: transform 0.3s ease;
}

.gallery-slider__images img:hover {
    transform: scale(1.05);
}

.slick-slide {
    opacity: 0.5;
    transition: opacity 0.5s ease-in-out;
}

.slick-active {
    opacity: 1;
}

.slick-arrow {
    background-color: rgba(0, 0, 0, 0.5);
    border-radius: 50%;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background-color 0.3s ease;
}

.slick-arrow:hover {
    background-color: rgba(0, 0, 0, 0.7);
}

.slick-arrow svg {
    fill: #fff;
}

.gallery-slider__thumbnails img {
    width: 100%;
    height: auto;
    border-radius: 4px;
    transition: border 0.3s ease, transform 0.3s ease;
}

.gallery-slider__thumbnails img:hover {
    border: 2px solid #007bff;
    transform: scale(1.1);
}

@media (max-width: 768px) {
    .gallery-slider__images, .gallery-slider__thumbnails {
        display: flex;
        flex-direction: column;
    }

    .gallery-slider__images img, .gallery-slider__thumbnails img {
        width: 100%;
        margin-bottom: 10px;
    }
}




<link rel="stylesheet" type="text/css" href="{{ asset('front/slick-date/date/slick.css') }}"/>

<link rel="stylesheet" type="text/css" href="{{ asset('front/slick-date/date/slick-theme.css') }}"/>



</style>

@endsection

@section('content')

@include('layouts.front.include.header1')

<main id="content" role="main">

         



        <!-- .gallery-slider -->

        <div class="gallery-slider">



          <!-- __images -->

          <div class="gallery-slider__images">

            <div>

            @foreach($to_city->images as $key => $img)   <!-- .item -->

              <div class="item">

              <div class="img-fill"><img  src="{{ $img->url }}" alt="{{ $to_city->name }}"></div>

              </div>

            @endforeach

              <!-- /.item -->



              <!-- /.item -->

            </div>

            <button class="prev-arrow slick-arrow">

              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1280 1792">

                <path fill="#fff" d="M1171 301L640 832l531 531q19 19 19 45t-19 45l-166 166q-19 19-45 19t-45-19L173 877q-19-19-19-45t19-45L915 45q19-19 45-19t45 19l166 166q19 19 19 45t-19 45z" />

              </svg>

            </button>

            <button class="next-arrow slick-arrow">

              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1280 1792">

                <path fill="#fff" d="M1107 877l-742 742q-19 19-45 19t-45-19l-166-166q-19-19-19-45t19-45l531-531-531-531q-19-19-19-45t19-45L275 45q19-19 45-19t45 19l742 742q19 19 19 45t-19 45z" />

              </svg>

            </button>



          </div>

          <!-- /__images -->





          <!-- __thumbnails -->

          <div class="gallery-slider__thumbnails">

            <div>

              @foreach($to_city->images as $key => $img)

              <div class="item">

                <div class="img-fill"><img src="{{ $img->url }}" alt=""></div>

              </div>

              @endforeach

              <!-- .item -->



              <!-- /.item -->

            </div>



            <button class="prev-arrow slick-arrow">

              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1280 1792">

                <path fill="#fff" d="M1171 301L640 832l531 531q19 19 19 45t-19 45l-166 166q-19 19-45 19t-45-19L173 877q-19-19-19-45t19-45L915 45q19-19 45-19t45 19l166 166q19 19 19 45t-19 45z" />

              </svg>

            </button>

            <button class="next-arrow slick-arrow">

              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1280 1792">

                <path fill="#fff" d="M1107 877l-742 742q-19 19-45 19t-45-19l-166-166q-19-19-19-45t19-45l531-531-531-531q-19-19-19-45t19-45L275 45q19-19 45-19t45 19l742 742q19 19 19 45t-19 45z" />

              </svg>

            </button>

          </div>

          



        </div>

    







        <div  id="item-container">

            @include('frontend.ajax-trip-list')

        </div>



</main>

@endsection

@section('front-additional-js')





<script type="text/javascript">



    var reloadUrl;

  



  



    $(document).on('click', '.trip-date', function() {

        var serial = $(this).attr('serial');

        var url = "{{ url('/') }}";

        var locale = "{{ app()->getLocale() }}";

        var date = $("#trip-date-"+serial).val();




        var city_from = "{{ $city_from->id }}";

        var city_to= "{{ $to_city->id }}";

        var main_feature_id= "{{ $main_feature_id }}";

        var number_of_person= "{{ $number_of_person }}";

        console.log(main_feature_id);

        if(main_feature_id == null){

            if(locale == 'en'){

                reloadUrl = url+'/trip-list?date='+date+'&city_from='+city_from+'&city_to='+city_to+'&type=1&number_of_person='+number_of_person;

            }else{

                reloadUrl = url+'/'+locale+'/trip-list?date='+date+'&city_from='+city_from+'&city_to='+city_to+'&type=1&number_of_person='+number_of_person;

            }

        }else{

            if(locale == 'en'){

                reloadUrl = url+'/trip-list?date='+date+'&city_from='+city_from+'&city_to='+city_to+'&type=1&number_of_person='+number_of_person+'&main_feature_id='+main_feature_id;

            }else{

                reloadUrl = url+'/'+locale+'/trip-list?date='+date+'&city_from='+city_from+'&city_to='+city_to+'&type=1&number_of_person='+number_of_person+'&main_feature_id='+main_feature_id;

            }

        }

        document.location.href=reloadUrl;

    });



    $(document).on('change', '#main-feature', function(e) {

        var main_feature_id = $(this).val();

        var url = "{{ url('/') }}";

        var locale = "{{ app()->getLocale() }}";

        var date = "{{ $date }}";



        var city_from = "{{ $city_from->id }}";

        var city_to= "{{ $to_city->id }}";

        var number_of_person= "{{ $number_of_person }}";



        if(locale == 'en'){

            reloadUrl = url+'/trip-list?date='+date+'&city_from='+city_from+'&city_to='+city_to+'&type=1&number_of_person='+number_of_person+'&main_feature_id='+main_feature_id;

        }else{

            reloadUrl = url+'/'+locale+'/trip-list?date='+date+'&city_from='+city_from+'&city_to='+city_to+'&type=1&number_of_person='+number_of_person+'&main_feature_id='+main_feature_id;

        }

        document.location.href=reloadUrl;

    });










</script>

@endsection

