<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\loginRequest;
use App\Http\Requests\registerRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ApiAuthController extends Controller
{

    public function register (registerRequest $request) {
        $request['password']=Hash::make($request['password']);
        $request['remember_token'] = Str::random(10);
        // $user = User::create($request->toArray());
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request['password'])
        ]);
       
        $token = $user->createToken('LaravelAuthApp')->accessToken;
        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        $user->save();
        $response = ['token' => $token];
        return response()->json(['data'=>$response], 200);
    }


    public function login (loginRequest $request) {
        
        $user = User::where('email', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                $user->save();
                $response = ['token' => $token];
                return response()->json(['data'=>$response], 200);
            } else {
                $response = ["message" => "Password mismatch"];
                return response($response, 422);
            }
        } else {
            $response = ["message" =>'User does not exist'];
            return response($response, 422);
        }
    }

    public function logout (Request $request) {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }

}
