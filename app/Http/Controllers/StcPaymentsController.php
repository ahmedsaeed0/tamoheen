<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Hash;
use Auth;
use App\Models\Order;
use App\Models\TripBooking;
use App\Models\ShipmentBooking;

class StcPaymentsController extends Controller
{
    public function stcProductPaymentConfirm(Request $request)
    {
        $this->validate($request, [
            'OtpReference' => 'required',
            'otp_value' => 'required',
            'StcPayPmtReference' => 'required',
            'token_ref' => 'required',
        ]);

    	$id= Crypt::decrypt($request->order_id);
    	$order = Order::findOrFail($id);

        $url = "https://b2btest.stcpay.com.sa/B2B.DirectPayment.WebApi/DirectPayment/V3/DirectPaymentConfirm";
        $content = [
            "DirectPaymentConfirmRequestMessage" => [
                'OtpReference'       => $request->OtpReference,
                'OtpValue'           => $request->otp_value,
                'StcPayPmtReference' => $request->StcPayPmtReference,
                'TokenReference'     => $request->token_ref,
                'TokenizeYn'         => true,
            ]
        ];

        $headers = ['Content-Type' => 'application/json', 'X-ClientCode' => '61238669970'];

        $json_content = json_encode($content);

        $client = new \GuzzleHttp\Client();
        $method = "POST";
        $response = $client->request($method, $url, [
            'json'    => $json_content,
            'headers' => $headers,
            'cert'    => base_path('forsanway_com_bf7d8_0d785_1596671999_d9296f3ee522f81fe77ddfb41e753a2d.crt'),
            'ssl_key' => base_path('bf7d8_0d785_3c597e2ac0ad59520e0496da7ae214dd.key')
            ]
        );
        $body = $response->getBody();
        $final_response = json_decode($body->read(1024));
        // dd($final_response);
        $order->payment_method = 'STC';
        $order->trx_id         = $final_response->DirectPaymentConfirmResponseMessage->TokenId;
        $order->stc_ref_num    = $final_response->DirectPaymentConfirmResponseMessage->RefNum;
        $order->order_status   = 1;
        $order->save();

        return redirect('product-payment-success/'.$order->id);


    }

    public function stcTripPaymentConfirm(Request $request)
    {
        $this->validate($request, [
            'OtpReference' => 'required',
            'otp_value' => 'required',
            'StcPayPmtReference' => 'required',
            'token_ref' => 'required',
        ]);

    	$id= Crypt::decrypt($request->trip_booking_id);
    	$tripbooking = TripBooking::findOrFail($id);


    	$url = "https://b2btest.stcpay.com.sa/B2B.DirectPayment.WebApi/DirectPayment/V3/DirectPaymentConfirm";
        $content = [
            "DirectPaymentConfirmRequestMessage" => [
                'OtpReference'       => $request->OtpReference,
                'OtpValue'           => $request->otp_value,
                'StcPayPmtReference' => $request->StcPayPmtReference,
                'TokenReference'     => $request->token_ref,
                'TokenizeYn'         => true,
            ]
        ];

        $headers = ['Content-Type' => 'application/json', 'X-ClientCode' => '61238669970'];

        $json_content = json_encode($content);

        $client = new \GuzzleHttp\Client();
        $method = "POST";
        $response = $client->request($method, $url, [
            'json'    => $json_content,
            'headers' => $headers,
            'cert'    => base_path('forsanway_com_bf7d8_0d785_1596671999_d9296f3ee522f81fe77ddfb41e753a2d.crt'),
            'ssl_key' => base_path('bf7d8_0d785_3c597e2ac0ad59520e0496da7ae214dd.key')
            ]
        );
        $body = $response->getBody();
        $final_response = json_decode($body->read(1024));

        $tripbooking->payment_method = 'STC';
        $tripbooking->trx_id = $final_response->DirectPaymentConfirmResponseMessage->TokenId;
        $tripbooking->stc_ref_num = $final_response->DirectPaymentConfirmResponseMessage->RefNum;
        $tripbooking->is_payment_complete = 1;
        $tripbooking->save();
        return view('frontend.trip-booking-success', compact('tripbooking'));
        // return redirect('paytab-payment-success/'.$tripbooking->id)->with('success', 'Payment Completed.');
    }

    public function stcShipPaymentConfirm(Request $request)
    {
        $this->validate($request, [
            'OtpReference' => 'required',
            'otp_value' => 'required',
            'StcPayPmtReference' => 'required',
            'token_ref' => 'required',
        ]);

    	$id= Crypt::decrypt($request->ship_booking_id);
    	$tripbooking = ShipmentBooking::findOrFail($id);


    	$url = "https://b2btest.stcpay.com.sa/B2B.DirectPayment.WebApi/DirectPayment/V3/DirectPaymentConfirm";
        $content = [
            "DirectPaymentConfirmRequestMessage" => [
                'OtpReference'       => $request->OtpReference,
                'OtpValue'           => $request->otp_value,
                'StcPayPmtReference' => $request->StcPayPmtReference,
                'TokenReference'     => $request->token_ref,
                'TokenizeYn'         => true,
            ]
        ];

        $headers = ['Content-Type' => 'application/json', 'X-ClientCode' => '61238669970'];

        $json_content = json_encode($content);

        $client = new \GuzzleHttp\Client();
        $method = "POST";
        $response = $client->request($method, $url, [
            'json'    => $json_content,
            'headers' => $headers,
            'cert'    => base_path('forsanway_com_bf7d8_0d785_1596671999_d9296f3ee522f81fe77ddfb41e753a2d.crt'),
            'ssl_key' => base_path('bf7d8_0d785_3c597e2ac0ad59520e0496da7ae214dd.key')
            ]
        );
        $body = $response->getBody();
        $final_response = json_decode($body->read(1024));

        $tripbooking->payment_method = 'STC';
        $tripbooking->trx_id = $final_response->DirectPaymentConfirmResponseMessage->TokenId;
        $tripbooking->stc_ref_num = $final_response->DirectPaymentConfirmResponseMessage->RefNum;
        $tripbooking->is_payment_complete = 1;
        $tripbooking->save();

        return redirect('shipment-payment-success/'.$tripbooking->id)->with('success', 'Payment Completed.');
    }
}
