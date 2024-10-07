<?php

namespace App\Traits;

 if (version_compare(phpversion(), '7.1', '>=')) {
    ini_set( 'serialize_precision', -1 );
    }
use Illuminate\Support\Facades\Auth;
use App\Traits\AddressTrait;
use Carbon\Carbon;
use Symfony\Component\Routing\Loader\Configurator\Traits\AddTrait;
use Illuminate\Support\Facades\Http;;

trait WaslTrait{
    
   
    use AddTrait;
    public $appsecret;
    public $clientid;
    public $appid;
    public $base_url;

    public function __construct(){
        $this->appsecret = '048080574895feb781e85cd43959851f';
    $this->clientid  = 'C92523BE-0590-4447-8DE0-09BCECAB37FD';
    $this->appid     = '78bfebfb';
    $this->base_url  = 'https://wasl.api.elm.sa/api/dispatching/v2/';
        
    }
    
       
    public function saveTrip($sentdata,$distance)
    {
        $durationInSeconds = $this->getDurationInSeconds($sentdata->date,$sentdata->drop_off_time);
        $customerWaitingTimeInSeconds = $this->getDurationInSeconds($sentdata->created_at,$sentdata->date);
        
        $data = [
            "sequenceNumber"=> $sentdata->trip->cars->sequence_number,
            "driverId"=> $sentdata->user->identity_number,
            "tripId"=> $sentdata->id,
            "distanceInMeters"=> (int) $distance,
            "durationInSeconds"=> $durationInSeconds,
            "customerRating"=> (double) $sentdata->reviews->avg('rating'),
            "customerWaitingTimeInSeconds"=> $customerWaitingTimeInSeconds,
            "originLatitude"=>(double) number_format($sentdata->trip->cityFrom->lat, 8),
            "originLongitude"=>(double) number_format($sentdata->trip->cityFrom->lng, 8, '.', ''),
            "destinationLatitude"=>(double) number_format($sentdata->trip->cityTo->lat, 8),
            "destinationLongitude"=>(double) number_format($sentdata->trip->cityTo->lng, 8),
            "pickupTimestamp"=> Carbon::parse($sentdata->date),
            "dropoffTimestamp"=> Carbon::parse($sentdata->drop_off_time),
            "startedWhen"=> Carbon::parse($sentdata->created_at),
            "tripCost"=> (double) $sentdata->price_per_person,
        ];

        // $headers = [
        //     'Content-Type' => 'application/json',
        //     'client-id' => $this->clientid,
        //     'app-id' => $this->appid,
        //     'app-key' => $this->appsecret
        // ];
        // $url = $this->base_url."trips";
        // $client = new \GuzzleHttp\Client();
        // try{
        //     $response = $client->post($url, [
        //         'headers' => $headers,
        //         'json' => $data
        //     ]);
        //      $responseBody = json_decode($response->getBody());
        //      dd($responseBody, 'result');
        // }
        $headers = [
            'Content-Type' => 'application/json',
            'client-id' => $this->clientid,
            'app-id' => $this->appid,
            'app-key' => $this->appsecret
        ];
        $url = $this->base_url."trips";
        $client = new \GuzzleHttp\Client();
        try{
            $response = $client->request('POST',$url, [
                'headers' => $headers,
                'json' => $data,
            ]);
            // $responseBody = json_decode($response->getBody());
            return  ['message' => 'success', 'status' => 'true' , 'data'=> $response->getBody() , "return"=>'true'];
        }
        catch(\GuzzleHttp\Exception\ClientException $e){
            $responseBody = $e->getResponse()->getBody(true);
            $res_data = json_decode($responseBody);
            $return = 'false';
            if(isset($res_data->resultCode) && $res_data->resultCode == 'bad_request'){
                if(isset($res_data->resultMsg)){
                    $message = $res_data;
                }else{
                    $message = $res_data;
                }                
            }else{
                $message = $res_data; 
                $return = 'false';
            }
            $status = $res_data->success;
            return  ['message' => $message, 'status' => $status , 'data'=> $res_data->resultCode , "return"=>$return];
        }
        catch(\Exception $e)
        {
            return  ['message' => $e->getMessage(), 'status' => 'false' , 'data'=> $e->getMessage() , "return"=> 'false'];
        }



    }

    public function saveDriver($responseData)
    {
        
        
        if(Auth::user()->identity_type == 1){
            $data = [
                "driver" => [
                    "identityNumber" => Auth::user()->identity_number,
                    "dateOfBirthHijri" => Auth::user()->partnerMetas->date_of_birth_hijri,
                    "emailAddress" => Auth::user()->email,
                    "mobileNumber" => Auth::user()->mobile
                ],
                "vehicle" => [
                    "sequenceNumber" => $responseData['sequence_number'],
                    "plateLetterRight" => $responseData['plate_letter_right'],
                    "plateLetterMiddle" => $responseData['plate_letter_middle'],
                    "plateLetterLeft" => $responseData['plate_letter_left'],
                    "plateNumber" => $responseData['plate_number'],
                    "plateType" => $responseData['plate_type']
                    ]
                ];
            }else{
            $data = [
                "driver" => [
                    "identityNumber" => Auth::user()->identity_number,
                    "dateOfBirthHijri" => Auth::user()->partnerMetas->date_of_birth_gregorian,
                    "emailAddress" => Auth::user()->email,
                    "mobileNumber" => Auth::user()->mobile
                ],
                "vehicle" => [
                    "sequenceNumber" => $responseData['sequence_number'],
                    "plateLetterRight" => $responseData['plate_letter_right'],
                    "plateLetterMiddle" => $responseData['plate_letter_middle'],
                    "plateLetterLeft" => $responseData['plate_letter_left'],
                    "plateNumber" => $responseData['plate_number'],
                    "plateType" => $responseData['plate_type']
                ]
            ];
        }

        $data = [
            "driver" => [
                "identityNumber" => Auth::user()->identity_number,
                "dateOfBirthHijri" => $responseData->user->partnerMetas->date_of_birth_hijri,
                "emailAddress" => Auth::user()->email,
                "mobileNumber" => Auth::user()->mobile
            ],
            "vehicle" => [
                "sequenceNumber" => $responseData->sequence_number,
                "plateLetterRight" => $responseData->plate_letter_right,
                "plateLetterMiddle" => $responseData->plate_letter_middle,
                "plateLetterLeft" => $responseData->plate_letter_left,
                "plateNumber" => $responseData->plate_number,
                "plateType" => $responseData->plate_type
            ]
        ];

        $headers = [
            'Content-Type' => 'application/json',
            'client-id' => $this->clientid,
            'app-id' => $this->appid,
            'app-key' => $this->appsecret
        ];

        $url = $this->base_url."drivers";
        $client = new \GuzzleHttp\Client();
        
        try{
            $response = $client->request('POST',$url, [
                'headers' => $headers,
                'json' => $data,
            ]);
            // return  json_decode($response->getBody());
            return  ['message' => 'success', 'status' => 'true' , 'data'=> $response->getBody() , "return"=>'true'];
        }
        catch(\GuzzleHttp\Exception\ClientException $e){
            $responseBody = $e->getResponse()->getBody(True);
            $res_data = json_decode($responseBody);
            $return = 'false';
            if(isset($res_data->resultCode) && $res_data->resultCode == 'bad_request'){
                if(isset($res_data->resultMsg)){
                    $message = $res_data;
                }else{
                    $message = $res_data;
                }                
            }else{
                $message = $res_data; 
                $return = 'true';
            }
            $status = $res_data->success;
            return  ['message' => $message, 'status' => $status , 'data'=> $res_data->resultCode , "return"=>$return];
        }
        catch(\Exception $e)
        {
            return  ['message' => $e->getMessage(), 'status' => 'false' , 'data'=> $e->getMessage() , "return"=> 'false'];
        }
    }

    public function checkEligibility($identityNumber)
    {
        
        $url = $this->base_url."drivers/eligibility/$identityNumber";
       
        $headers = [
            'Content-Type' => 'application/json',
            'client-id' => $this->clientid,
            'app-id' => $this->appid,
            'app-key' => $this->appsecret
        ];
        
    
        $client = new \GuzzleHttp\Client();
        try{
            $response = $client->get($url, [
                    'headers' => $headers
                ]);
                
                return ['message' => "Data Successfuly Fetched.", 'status' => 200, 'data'=> json_decode($response->getBody())];
                // return  json_decode($response->getBody());
            }
            
        catch(\GuzzleHttp\Exception\ClientException $e){
            // dd($response);
            return ['message' =>  'عذرا ليس لديك الاهلية من وزارة النقل العام ', 'status' => 400, 'data'=> "N/A"];

        }
    }
}
