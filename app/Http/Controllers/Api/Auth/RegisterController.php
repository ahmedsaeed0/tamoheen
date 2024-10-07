<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\User;
use App\Models\Image;
use App\Models\PartnerMeta;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{

	public function registerUser(Request $request){
		$validator = Validator::make($request->all(), [
			'name'     => 'required|string',
			'email'    => 'required|email|unique:users',
			'password' => 'required|string|min:8',
			'mobile'   => 'required|regex:/^([0-9\s\-\+\(\)]*)$/',
		]);

		if($validator->fails())
			return response()->json(['error' => $validator->errors()->all(), 'code' => 422], 422);

	    $user = new User([
	        'name'            => $request->name,
	        'email'           => $request->email,
	        'password'        => Hash::make($request->password),
	        'mobile'          => $request->mobile,
	        'language'        => "en",
	        'status'          => 0,
	    ]);

	    $user->save();

	    if($user){
            $user->syncRoles(['user']);
            if($request->hasFile('user_image')){
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
        }

	    return response()->json([
	        'message' => 'Successfully created User!',
	        'code' => 201
	    ], 201);
	}

	public function registerPartner(Request $request)
	{
		 $validator = Validator::make($request->all(), [
			'title'           => 'required|string',
			'name'            => 'required|string',
			'email'           => 'required|string|email|unique:users',
			'password'        => 'required|string|confirmed',
			'mobile'          => 'required|regex:/^([0-9\s\-\+\(\)]*)$/',
			'address'         => 'required|string',
			'license'         => 'required|string',
			'license_file'    => 'required|mimes:jpeg,bmp,png,pdf',
	    ]);

		if($validator->fails())
			return response()->json(['error' => $validator->errors()->all(), 'code' => 422], 422);
			
			// dd($request->all());
	    $user = new User([
	        'title'           => $request->title,
	        'name'            => $request->name,
	        'email'           => $request->email,
	        'password'        => Hash::make($request->password),
	        'mobile'          => $request->mobile,
	        'identity_type'   => $request->identity_type,
	        'identity_number' => $request->identity_number,
	        'language'        => "en",
	        'status'          => 0,
	    ]);

	    $user->save();
	    if($user){
	    	if($request->hasFile('license_file')){
        		$license_file = $request->file('license_file');
        		$name = uniqid().'.'.strtolower($license_file->getClientOriginalExtension());
        		$path = $license_file->storeAs(
                    'license-file', $name, 'public'
                );
        	}else{
        		$path = null;
        	}
	    	$partner                 = new PartnerMeta;
	    	$partner->user_id        = $user->id;
	    	$partner->address        = $request->address;
	    	$partner->license_number = $request->license;
	    	$partner->license_file   = $path;
	    	$partner->save();
	    	
            $user->syncRoles(['partner']);

            if($request->hasFile('user_image')){
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

        	

		    return response()->json([
		        'message' => 'Successfully created Partner!',
		        'code' => 201
		    ], 201);
		}
	}
    
}
