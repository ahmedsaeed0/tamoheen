<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Review;
use App\Models\ShipReview;
use Auth;

class ReviewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        if($user->hasrole('partner'))
        {
            $reviews = Review::with(['ratingFrom', 'tripBooking' => function($q){
                $q->with('trip');
            }])->latest()->paginate(25);
        }else{
            $reviews = Review::with(['ratingFrom', 'ratingTo', 'tripBooking' => function($q){
                $q->with('trip');
            }])->latest()->paginate(25);
        }
        return view('reviews.index', compact('reviews'));
    }

    public function indexShip()
    {
        $user = Auth::user();
        if($user->hasrole('partner'))
        {
            $reviews = ShipReview::with(['ratingShipFrom', 'tripBooking' => function($q){
                $q->with('trip');
            }])->latest()->paginate(25);
        }else{
            $reviews = ShipReview::with(['ratingShipFrom', 'ratingShipTo', 'tripBooking' => function($q){
                $q->with('trip');
            }])->latest()->paginate(25);
        }

        

        return view('reviews.index-ship', compact('reviews'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Review::destroy($id);
        return redirect('reviews')->with('success', 'Review deleted');
    }

    public function destroyShip($id)
    {
        ShipReview::destroy($id);
        return redirect('review-ships')->with('success', 'Review deleted');
    }
}
