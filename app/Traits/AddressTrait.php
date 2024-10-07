<?php

namespace App\Traits;

use DateTime;

trait AddressTrait{
    public function getLatLngFromAddress($address){
        $key = env("GOOGLE_API_KEY");
        $url = "https://maps.google.com/maps/api/geocode/json?key=$key&address=".urlencode($address);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $responseJson = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($responseJson);

        if ($response->status == 'OK') {
            $data['lat'] = $response->results[0]->geometry->location->lat;
            $data['lng'] = $response->results[0]->geometry->location->lng;
            return $data;
        } else {
            return $response->status;
        }
    }

    public function getDistanceMeters($data)
    {
        $theta    = $data['lng1'] - $data['lng2'];
        $dist    = sin(deg2rad($data['lat1'])) * sin(deg2rad($data['lat2'])) +  cos(deg2rad($data['lat1'])) * cos(deg2rad($data['lat2'])) * cos(deg2rad($theta));
        $dist    = acos($dist);
        $dist    = rad2deg($dist);
        $miles    = $dist * 60 * 1.1515;

        // Convert unit and return distance
        $unit = strtoupper("M");
        if($unit == "K"){
            return round($miles * 1.609344, 2).' km';
        }elseif($unit == "M"){
            return round($miles * 1609.344, 0);
        }else{
            return round($miles, 2).' miles';
        }
    }


    public function getDurationInSeconds($startTime,$endTime)
    {
        $startTime = new DateTime($startTime);
        $endTime = new DateTime($endTime);
        $diff = $startTime->diff($endTime);

        $daysInSecs = $diff->format('%r%a') * 24 * 60 * 60;
        $hoursInSecs = $diff->h * 60 * 60;
        $minsInSecs = $diff->i * 60;

        $seconds = $daysInSecs + $hoursInSecs + $minsInSecs + $diff->s;
        return $seconds;
    }
}
