<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
 
class AuthController extends Controller 
{
    /**
     * Login using the specified resource.
     */
    public function login(UserRequest $request)
    {   
         $user = User::where('email', $request->email)->first();
     
        if (! $user || ! Hash::check($request->password, $user->password)) { //guard clause technique 
            throw ValidationException::withMessages([
                'message' => ['Not Registered.'],
            ]);
        }

        $response = [
            'user'  => $user,
            'token' => $user->createToken($request->email)->plainTextToken
        ];

        return $response;       
    }

     /**
     * Logout using the specified resource.
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        $response = [
            'message' => 'Logout.'
        ];

        return $response;
    }
}
