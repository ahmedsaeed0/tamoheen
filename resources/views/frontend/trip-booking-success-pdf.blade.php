<html>
    <head>
    <title>Bording Pass</title>
   
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <meta name="viewport" content="width=device-width, initial-scale=1">
     <style type="text/css">
      @font-face {
        font-family: 'Source Sans Pro';
        font-style: normal;
        font-weight: normal;
        src: local('Source Sans Pro'), local('SourceSansPro-Regular'), url(http://themes.googleusercontent.com/static/fonts/sourcesanspro/v7/ODelI1aHBYDBqgeIAH2zlNzbP97U9sKh0jjxbPbfOKg.ttf) format('truetype');
      }
      @font-face {
        font-family: 'Source Sans Pro';
        font-style: normal;
        font-weight: bold;
        src: local('Source Sans Pro Bold'), local('SourceSansPro-Bold'), url(http://themes.googleusercontent.com/static/fonts/sourcesanspro/v7/toadOcfmlt9b38dHJxOBGLsbIrGiHa6JIepkyt5c0A0.ttf) format('truetype');
      }
      @font-face {
        font-family: 'Source Sans Pro';
        font-style: italic;
        font-weight: normal;
        src: local('Source Sans Pro Italic'), local('SourceSansPro-It'), url(http://themes.googleusercontent.com/static/fonts/sourcesanspro/v7/M2Jd71oPJhLKp0zdtTvoM0DauxaEVho0aInXGvhmB4k.ttf) format('truetype');
      }
      @font-face {
        font-family: 'Source Sans Pro';
        font-style: italic;
        font-weight: bold;
        src: local('Source Sans Pro Bold Italic'), local('SourceSansPro-BoldIt'), url(http://themes.googleusercontent.com/static/fonts/sourcesanspro/v7/fpTVHK8qsXbIeTHTrnQH6Edtd7Dq2ZflsctMEexj2lw.ttf) format('truetype');
      }
      body {
       
       
        font-family: 'Source Sans Pro', normal;
      }
      
      </style>
    <style type="text/css">
     

      @page { size: a4 portrait; }
      .table-bordered , tr > th >td {
          border: 1px solid white !important;
      }
    .mytable {

      font-size:8px;
      border-collapse: collapse;
      width: 100%;
      width: 100%;
      background-color: white;
     
    }
    .mytable-head {
      font-size:8px;
      border: 1px solid black;
      margin-bottom: 0;
      padding-bottom: 0;
    }
    .mytable-head td {
      font-size:8px;
      border: 1px solid black;
      word-break: break-all !important;
    }
    .mytable-body {
      font-size:8px;
      border: 1px solid black;
      border-top: 0;
      margin-top: 0;
      padding-top: 0;
      margin-bottom: 0;
      padding-bottom: 0;
    }
    .mytable-body td {
      font-size:8px;
      border: 1px solid black;
      border-top: 0;
    }
    .mytable-footer {
      font-size:8px;
      border: 1px solid black;
      border-top: 0;
      margin-top: 0;
      padding-top: 0;
    }
    .mytable-footer td {
      font-size:8px;
      border: 1px solid black;
      border-top: 0;
    }
    * { /* this works for all but td */
      word-wrap:break-word;
    }
    

    th, td {
      font-size: 8px;
    }
  </style>
    </head>
    <body>
        <main id="content" class="bg-gray space-2">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12  col-lg-8  ">
                        <div class="mb-5 shadow-soft bg-white rounded-sm">
                            <div class="pt-4 pb-5 px-5">
                                
                                <!-- Tab Content -->
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="paytab" role="tabpanel" aria-labelledby="pills-one-example2-tab">                                           
                                        <div style="width: 100%" class=" w-full">
                                            <div >
                                                <div class="row justify-content-center">
                                                    <table style="width:100%;position: absolute;bottom: 0; top: 0;left: 0;right: 0;" class="table table-bordered">
                                                        <tbody class="text-center">
                                                            <tr>
                                                                <td colspan="2" style="font-size:18px;font-weight:bold;text-align: center; border: 1px solid black !important;"><h2>@lang('content.boarding_info')</h2></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="50%" style="font-size:18px;padding:10px;font-weight:bold;text-align: center; border: 1px solid black !important;">
                                                                    <img id="qrcode"  width="200" src="https://forsanway.com/public{{$image}}" alt="" srcset="">
                                                                </td>
                                                                <td width="50%" style="font-size:18px;;padding:10px;font-weight:bold;text-align: center; border: 1px solid black !important;">
                                                                    <img id="logo" width="200" src="https://forsanway.com/front/assets/images/logo.png" alt="" srcset="">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="font-size:18px;font-weight:bold;text-align: center; border: 1px solid black !important;">
                                                                @lang('booking-list.trip') 
                                                                </td>
                                                                <td style="font-size:18px;text-align: center; border: 1px solid black !important;">
                                                                @if(app()->getLocale() == 'ur')
                                                                      {{ $tripbooking->trip->title_urdu }}
                                                                  @elseif(app()->getLocale() == 'ar')
                                                                      {{ $tripbooking->trip->title_arabic }}
                                                                  @else
                                                                      {{ $tripbooking->trip->title }}
                                                                  @endif
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="font-size:18px;font-weight:bold;text-align: center; border: 1px solid black !important;">@lang('booking-list.price')</td>
                                                                <td style="font-size:18px;text-align: center; border: 1px solid black !important;">{{ $tripbooking->price}}</td>
                                                            </tr>
                                                            @foreach($passengers as $d)
                                                            <tr>
                                                                <td style="font-size:18px;font-weight:bold;text-align: center; border: 1px solid black !important;">@lang('content.name')</td>
                                                                <td style="font-size:18px;text-align: center; border: 1px solid black !important;">{{ $d->name ?? '' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="font-size:18px;font-weight:bold;text-align: center; border: 1px solid black !important;">@lang('content.id')</td>
                                                                <td style="font-size:18px;text-align: center; border: 1px solid black !important;">{{  $d->identity_number ?? '' }}</td>
                                                            </tr>
                                                            @endforeach
                                                            
                                                            <tr>
                                                                <td style="font-size:18px;font-weight:bold;text-align: center; border: 1px solid black !important;">Trip no</td>
                                                                <td style="font-size:18px;text-align: center; border: 1px solid black !important;">{{ $tripbooking->trip->id ?? '' }}</td>
                                                            </tr>

                                                            <tr>
                                                                <td style="font-size:18px;font-weight:bold;text-align: center; border: 1px solid black !important;">Trip Name</td>
                                                                <td style="font-size:18px;text-align: center; border: 1px solid black !important;">{{ $tripbooking->trip->title ?? '' }}</td>
                                                            </tr>

                                                            <tr>
                                                                <td style="font-size:18px;font-weight:bold;text-align: center; border: 1px solid black !important;">@lang('content.start_point')</td>
                                                                <td style="font-size:18px;text-align: center; border: 1px solid black !important;">{{ $tripbooking->trip->start_point ?? '' }}</td>
                                                            </tr>

                                                            <tr>
                                                                <td style="font-size:18px;font-weight:bold;text-align: center; border: 1px solid black !important;">@lang('content.end_point')</td>
                                                                <td style="font-size:18px;text-align: center; border: 1px solid black !important;">{{ $tripbooking->trip->end_point ?? '' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="font-size:18px;font-weight:bold;text-align: center; border: 1px solid black !important;">@lang('content.driver_name')</td>
                                                                <td style="font-size:18px;text-align: center; border: 1px solid black !important;">{{ $tripbooking->trip->user->name ?? '' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="font-size:18px;font-weight:bold;text-align: center; border: 1px solid black !important;">@lang('content.driver_phone')</td>
                                                                <td style="font-size:18px;text-align: center; border: 1px solid black !important;">{{ preg_replace('/[+]/', "", $tripbooking->trip->user->mobile) ?? '' }}</td>
                                                            </tr>
                                                            <!--<tr>-->
                                                            <!--    <td style="font-size:18px;font-weight:bold;text-align: center; border: 1px solid black !important;">@lang('content.plate')</td>-->
                                                            <!--    <td style="font-size:18px;text-align: center; border: 1px solid black !important;">{{ $tripbooking->trip->cars->plate_number ?? '' }}</td>-->
                                                            <!--</tr>-->
                                                            
                                                            <tr>
                                                                <td style="font-size:18px;font-weight:bold;text-align: center; border: 1px solid black !important;">@lang('content.plate_type')</td>
                                                                <td style="font-size:18px;text-align: center; border: 1px solid black !important;">{{ $tripbooking->trip->cars->plate_letter_left ?? ' ' }} {{  $tripbooking->trip->cars->plate_letter_middle ?? ' '}} {{  $tripbooking->trip->cars->plate_letter_right   }} {{ $tripbooking->trip->cars->plate_number ?? '' }}</td>
                                                            </tr>

                                                            <tr>
                                                                <td style="font-size:18px;font-weight:bold;text-align: center; border: 1px solid black !important;">@lang('content.date')</td>
                                                                <td style="font-size:18px;text-align: center; border: 1px solid black !important;">{{ Carbon\Carbon::parse($tripbooking->trip->date)->format('Y-m-d') }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="font-size:18px;font-weight:bold;text-align: center; border: 1px solid black !important;">@lang('content.time')</td>
                                                                <td style="font-size:18px;text-align: center; border: 1px solid black !important;">{{ Carbon\Carbon::parse($tripbooking->trip->date)->format('H:i A') }}</td>
                                                            </tr>

                                                        </tbody>
                                                    </table>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Tab Content -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <script>
            window.onload = function() {
              window.print();
            };
        </script>
    </body>
</html>


