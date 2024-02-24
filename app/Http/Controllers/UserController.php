<?php

namespace App\Http\Controllers;

use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\employer;


class UserController extends Controller
{
    public function __construct() {

    }
    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|max:255|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors(),
                'status' => response::HTTP_BAD_REQUEST]);
        }

        // If validation passes, create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        auth()->login($user);

        return response()->json([
            'success' => 'Signup successful!',
            'status' => response::HTTP_ACCEPTED]);
    }

    public function signupEmployer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|max:255|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors(),
                'status' => response::HTTP_BAD_REQUEST]);
        }

        // If validation passes, create the user
        $user = employer::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        auth()->login($user);

        return response()->json([
            'success' => 'Signup successful!',
            'status' => response::HTTP_ACCEPTED]);
    }

    public function me(){
        $user= auth()->user();

        return response()->json([
            'email' => $user->email,
            'name' => $user->name,
        ]);
    }

    public function signin(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors(),
                'status' => Response::HTTP_BAD_REQUEST
            ]);
        }

        // Attempt to authenticate the user
        if (!auth()->attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid credentials',
                'status' => Response::HTTP_UNAUTHORIZED
            ]);
        }

        return response()->json([
            'message' => 'Login successful',
            'status' => Response::HTTP_OK
        ]);
    }

    public function logout(Request $request){

        JWTAuth::parseToken()->invalidate();

        return response()->json([
            'message' => 'Gebruiker is uitgelogd',
            'status' => response::HTTP_ACCEPTED]);
    }
}
