<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    //Please add this method
    public function login() {
        // get email and password from request
        $credentials = request(['email', 'password']);

        // try to auth and get the token using api authentication
        if (!$token = auth('api')->attempt($credentials)) {
            // if the credentials are wrong we send an unauthorized error in json format
            return response()->json(['message' => 'Invalid Credentials. Try again', 'status' => 'error'], 401);
        }

        return response()->json([
            'credentials' => [
                'user' => auth('api')->user(),
                'token' => $token,
                'type' => 'bearer', // you can ommit this
                'expires' => auth('api')->factory()->getTTL()
            ],
            'message' => "Logged In. Redirecting you in a bit.",
            'status' => 'success'
        ]);
    }

    public function register(Request $request) {
        try {
            $this->validate($request, [
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required',
            ]);

            // check if user already exists
            $user = User::where('email', $request->email)->first();
            if($user) return response()->json(['message' => 'User already exists', 'status' => 'error'], 400);

            $saved_user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            if($saved_user)
                return response()->json(['message' => 'Registered. You may now login', 'status' => 'success']);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->getMessage(), 'type' => 'error'], 400);
        }
    }
}
