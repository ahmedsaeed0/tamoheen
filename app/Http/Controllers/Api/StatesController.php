<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Country;
use App\Models\State;
use App\Models\User;
use Auth;

class StatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $states = State::with('countries')->get();
        return response()->json([
            'states' => $states
        ]);
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
        $request->validate([
            'country_id' => 'required',
            'name'       => 'required',
        ]);

        $state              = new State;
        $state->name        = $request->name;
        $state->name_arabic = $request->name_arabic;
        $state->name_urdu   = $request->name_urdu;
        $state->country_id  = $request->country_id;
        $state->save();

        return response()->json([
            'message' => 'State Created',
            'state'   => $state
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
        $state = State::with('countries')->findOrFail($id);
        return response()->json([
            'state' => $state
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
        $state = State::with('countries')->findOrFail($id);
        return response()->json([
            'state' => $state
        ]);
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
        $state              = State::findOrFail($id);
        $state->name        = $request->name;
        $state->name_arabic = $request->name_arabic;
        $state->name_urdu   = $request->name_urdu;
        $state->country_id  = $request->country_id;
        $state->save();

        return response()->json([
            'message' => 'State Updated',
            'state'   => $state
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        State::destroy($id);
        return response()->json([
            'message' => 'State Deleted'
        ]);
    }
}
