<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Register new user
    public function register(Request $request)
    {
        $requestData = $request->all();
        $validator = Validator::make($requestData,[
            'name' => 'required|max:55',
            'email' => 'email|required|unique:users',
            'password' => 'required|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $requestData['password'] = Hash::make($requestData['password']);

        $user = User::create($requestData);

        $data['title'] = 'Registed Successfully!';
        $data['body'] = 'Registration Successful';
        $data['to'] = $user->email;
        Mail::send('email', $data,function ($m) use ($data) {
            $m->to($data['to'])->subject('Registed Successfully');
        });

        return response([ 'status' => true, 'message' => 'User successfully register.' ], 200);
    }
    // Login User
    public function login(Request $request)
    {
        $requestData = $request->all();
        $validator = Validator::make($requestData,[
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        if(! auth()->attempt($requestData)){
            return response()->json([
                'errors' => ['message' => [0 => 'Unauthorised Access']]
            ], 401);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return response(['user' => auth()->user(), 'access_token' => $accessToken], 200);
    }

    public function me(Request $request)
    {
        $user = $request->user();

        return response()->json(['user' => $user], 200);
    }
    // Logout
    public function logout (Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }
}