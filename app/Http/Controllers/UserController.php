<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

//  auth: Jan-Pieter Ott
//  Deze controller is verantwoordelijk voor het aanmaken van nieuwe gebruikers en de sessies die zij aanmaken.

class UserController extends Controller
{
    public function __construct() {

    }

    //functie om voor een normale gebruiker om een account aan te maken
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

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'is_admin' => 0,
            'password' => bcrypt($request->password),
        ]);

        auth()->login($user);

        return response()->json([
            'success' => 'Signup successful!',
            'status' => response::HTTP_ACCEPTED]);
    }

    //functie om account gegevens op te halen
    public function me(){

        $user = JWTAuth::parseToken()->authenticate();

        return response()->json(['user' => $user]);
    }

    //functie om gebruikers in te loggen.
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

        if (!auth()->attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid credentials',
                'status' => Response::HTTP_UNAUTHORIZED
            ]);
        }

        $token = JWTAuth::fromUser(Auth::user());

        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'status' => Response::HTTP_OK
        ]);
    }

    //functie om de gebruikers uit te loggen.
    public function logout(Request $request){

        JWTAuth::parseToken()->invalidate();

        return response()->json([
            'message' => 'Gebruiker is uitgelogd',
            'status' => response::HTTP_ACCEPTED]);
    }
}
