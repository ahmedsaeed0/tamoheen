<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Image;
use Auth;
use Hash;
use Storage;

class UsersController extends Controller
{
    public function changePassword(Request $request){
    	$this->validate($request,[
            'old_password'      => ['required', 'string', 'min:8'],
            'new_password'      => ['required', 'string', 'min:8'],
            'confirm_password'  => ['required', 'string', 'min:8'],
        ]);

        $old_password       = $request->old_password;
        $new_password       = $request->new_password;
        $confirm_password   = $request->confirm_password;
        
        
        if($new_password == $confirm_password){
            $current_password = Auth::user()->password;
            if(Hash::check($old_password, $current_password))
            {
                $id             = Auth::user()->id;
                $user           = User::findOrFail($id);
                $user->password = Hash::make($new_password);
                $user->save(); 
                return response()->json(['message'=>'Passowrd Updated!']);
            }
        }else{
            return response()->json(['message'=>'New Password and Confirm password not matching!']);
        }
    }

    public function userList()
    {
    	$users = User::role('user')->where('status', 1)->with('image')->get();
    	return response()->json($users);
    }

    public function currentUserDetail()
    {
        $user = User::with('partnerMetas','image')->findOrFail(Auth::id());
        return response()->json([
            'user' => $user
        ]);
    }

    public function driverList()
    {
        $partners = User::role('partner')->with('partnerMetas', 'image')->get();
        return response()->json([
            'partners' => $partners
        ]);
    }

    public function userActive($id)
    {
    	$user = User::findOrFail($id);
    	$user->status = 1;
    	$user->save();

    	return response()->json([
            'message' => 'User Activated'
        ]);
    }

    public function userDeactive($id)
    {
    	$user = User::findOrFail($id);
    	$user->status = 0;
    	$user->save();

    	return response()->json([
            'message' => 'User Deactivated'
        ]);
    }

    public function logoutApi(Request $request){
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    public function addAdmin(Request $request){
        $request->validate([
            'title'           => 'required|string',
            'name'            => 'required|string',
            'email'           => 'required|string|email|unique:users',
            'password'        => 'required|string|confirmed',
            'mobile'          => 'required',
            'identity_type'   => 'required',
            'identity_number' => 'required',
        ]);
        $user = new User([
            'title'           => $request->title,
            'name'            => $request->name,
            'email'           => $request->email,
            'password'        => Hash::make($request->password),
            'mobile'          => $request->mobile,
            'identity_type'   => $request->identity_type,
            'identity_number' => $request->identity_number,
            'language'        => "en",
            'status'          => 1,
        ]);

        $user->save();
        if($user){
            $user->syncRoles(['admin']);
            if($request->hasFile('user_image')){
                $user_image = $request->file('user_image');
                $name = uniqid().'.'.strtolower($user_image->getClientOriginalExtension());
                $path = $user_image->storeAs(
                    'users', $name, 'public'
                );
                $userImage = new Image;
                $userImage->url = $path;
                $userImage->imageable_id = $user->id;
                $userImage->imageable_type = 'App\Models\User';
                $user->image()->save($userImage);
            }

        }

        return response()->json([
            'message' => 'Successfully created User!'
        ], 201);
    }

    public function updateUserDetail(Request $request)
    {
       $user                  = User::findOrFail(Auth::id());
       $user->title           = $request->title;
       $user->name            = $request->name;
       $user->mobile          = $request->mobile;
       $user->identity_type   = $request->identity_type;
       $user->identity_number = $request->identity_number;
       $user->save();

        if($request->user_image){
            $image = $user->image;
            $exists = Storage::disk('public')->exists($image->url);
            if($exists){
                Storage::disk('public')->delete($image->url);
            }
            $user->image()->delete();

            $userImage = new Image;
            $user_image = $request->file('user_image');
            $name = uniqid().'.'.strtolower($user_image->getClientOriginalExtension());
            $path = $user_image->storeAs(
                'users', $name, 'public'
            );
            $userImage->url = $path;
            $userImage->imageable_id = $user->id;
            $userImage->imageable_type = 'App\Models\User';
            $user->image()->save($userImage);
        }

       if($user->hasRole('partner')){
            $partner                 = $user->partnerMetas;
            $partner->address        = $request->address;
            $partner->license_number = $request->license;
            $partner->save();
            return response()->json([
                'user'=> $user,
                'partner'=>$partner,
                'message' => 'Details Updated!'
           ]);
        }
       return response()->json([
            'user'=> $user,
            'message' => 'Details Updated!'
       ]);
    }
}
