<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\State;
use App\Models\City;
use App\Models\Image;
use App\Traits\AddressTrait;
use Auth;
use Storage;
use App\Models\User;
use App\Models\TripBooking;
use App\Models\Trip;

class ReferralsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $getuser = Auth::user();
        $user = User::with('partnerMetas', 'image')->findOrFail($getuser->id);
        if(!empty($user->referralcode)){
            $referralsUser = User::where('referralcodefrom', $user->referralcode)->where('referralcodefrom', $user->referralcode)->get();
            foreach ($referralsUser as $key => $value) {
                $referralsUser[$key]->TotalCompleteTrip = $this->TotalCompleteTrip($value->id);
                $referralsUser[$key]->TotalTrip = $this->TotalTrip($value->id);
            }
        }else{
            $referralsUser = [];
        }
    	return view('users.referralShow', compact('user','referralsUser'));
    }

    public function TotalCompleteTrip($id)
    {
        $tripCount = TripBooking::where('partner_id', $id)->where('status', 4)->count();
        return $tripCount;
    }

    public function TotalTrip($id)
    {
        $tripCount = Trip::where('user_id', $id)->count();
        return $tripCount;
    }
}