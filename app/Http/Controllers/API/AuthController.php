<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;


class AuthController extends Controller
{
  public $successStatus = 200;
    public function register(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|max:55',
            'email' => 'email|required|unique:users',
            'password' => 'required|confirmed'
        ]);

        $validatedData['password'] = bcrypt($request->password);

        $user = User::create($validatedData);

        $accessToken = $user->createToken('authToken')->accessToken;
        //nb: faire condition si il a tel email alors admin sinon  user (User Manager)
        if($request->email==="administrateur@gmail.com"){
            $user->assignRole('super-admin');
        }else{
            $user->assignRole('user');
        }

        return response()->json([ 'user' => $user, 'access_token' => $accessToken],$this->successStatus);



    }

    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($loginData)) {
            return response(['message' => 'Invalid Credentials']);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return response()->json(['user' => auth()->user(), 'access_token' => $accessToken,'role'=>  auth()->user()->getRoleNames()],$this->successStatus);

    }
}
