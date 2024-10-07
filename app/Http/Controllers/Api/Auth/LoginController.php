<?php



namespace App\Http\Controllers\Api\Auth;



use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;



use Hash;

use Auth;

use App\Models\User;

use Carbon\Carbon;

use Illuminate\Support\Facades\Validator;



class LoginController extends Controller

{

    public function login(Request $request)

    {


    	$request->validate([

            'remember_me' => 'boolean',

            'password'    => 'required|string',

            'email'       => 'required|string|email',

        ]);

        $credentials = request(['email', 'password']);

        if(!Auth::attempt($credentials))

            return response()->json([

                "error" => [

                    "password" => "Email or password doesn't match our credentials ."

                ],

                'message' => 'Unauthorized'

            ], 401);

        $user = $request->user();

        $roles = $user->getRoleNames();

        $tokenResult = $user->createToken('Personal Access Token');

        

        $token = $tokenResult->token;

        if ($request->remember_me)

            $token->expires_at = Carbon::now()->addWeeks(1);

            $token->save();

        return response()->json([

            'roles'        => $roles,

            'user'         => $user,

            'access_token' => $tokenResult->accessToken,

            'token_type'   => 'Bearer',

            'expires_at'   =>Carbon::parse($tokenResult->token->expires_at)->timestamp,

            'code' => 201

        ], 201);

    }

}

