<!DOCTYPE html>

<html>

<head>

	<title>Scan the following QR code</title>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

	<style>

	    .main-box{

	        width: 600px;

	    }

	    

	    table , .title-div{

	        width: 100%;

	    }

	    

	    .title-div{

	        border: 1px solid black;

            text-align: center;

	    }

	    table , tr ,td, th{

	        text-align: center;

	    }

	</style>

</head>

<body>

    <div class="main-box">

        <!-- <div class="title-div"><h2>Trip information</h2></div> -->
        <div class="title-div"><h2>{{$brand_name}} - {{$trip_id}}</h2></div>
        
        <table border="1">

            <tr>
        
                <td><img src="{{ $qr_url.$image }}" width="200px;" /></td>

                <td><img contain width="auto" height="120px" src="https://tamoheen.com/front/assets/images/logo.png" alt="" srcset=""></td>

            </tr>

             <tr>

                <td><h4>Price</h4></td>

                <td><h4>{{$trips->price}}</h4></td>

            </tr>

             <tr>

                <td><h4>Passanger name</h4></td>

                <td><h4>{{$name}}</h4></td>

            </tr>

            <tr>

                <td><h4>Trip ID</h4></td>

                <td><h4>{{$trip_id}}</h4></td>

            </tr>

            <tr>

                <td><h4>Brand Name</h4></td>

                <td><h4>{{$brand_name}}</h4></td>

            </tr>

            <tr>
                <td><h4>Passanger ID</h4></td>

                <td><h4>{{$trips->user_id}}</h4></td>

            </tr>

             <tr>

                <td><h4>Pick up location</h4></td>

                <td><h4>{{@print_r($request->start_point)}}</h4></td>

            </tr>

             <tr>

                <td><h4>Drop off location</h4></td>

                <td><h4>{{@print_r($request->end_point)}}</h4></td>

            </tr>

             <tr>

                <td><h4>Driver name</h4></td>

                <td><h4>{{$request->title}}</h4></td>

            </tr>

             <tr>

                <td><h4>Mobile number for driver</h4></td>

                <td><h4>{{$mobile}}</h4></td>

            </tr>

             <tr>

                <td><h4>Car plate number</h4></td>

                <td><h4>{{$cars->plate_number}}</h4></td>

            </tr>

             <tr>

                <td><h4>Trip date</h4></td>
                <td>{{ Carbon\Carbon::parse($request->date)->format('Y-m-d') }}</td>

            </tr>

            <tr>

                <td><h4>Trip time</h4></td>
                <td>{{ Carbon\Carbon::parse($request->date)->format('H:i A') }}</td>

            </tr>

        </table>



    </div>

    



</body>

</html>