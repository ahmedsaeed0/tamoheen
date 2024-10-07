<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ComplainResource;
use App\Complain;
use Auth;

class ComplainsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $complains = Complain::latest()->get();
        return  ComplainResource::collection($complains); 
        
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
        $complain                     = new Complain;
        $complain->trip_id            = $request->trip_id;
        $complain->complain_from_id   = Auth::id();
        $complain->complain_to_id     = $request->complain_to_id;
        $complain->title              = $request->title;
        $complain->title_arabic       = $request->title_arabic;
        $complain->title_urdu         = $request->title_urdu;
        $complain->description        = $request->description;
        $complain->description_arabic = $request->description_arabic;
        $complain->description_urdu   = $request->description_urdu;
        $complain->save();

        return response()->json([
            'message' => 'Complain created!'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $complain = Complain::findOrFail($id);
        return response()->json([
            'complain' => $complain
        ]);
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
        Complain::destroy($id);
        return response()->json([
            'message' => 'Complain deleted!'
        ]);
    }
}
