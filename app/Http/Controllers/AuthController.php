<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
class AuthController extends Controller
{
    //
   
        public function registerUser(AuthRequest $request){
            $validated = $request->validated();
            // Check if a file has been uploaded

            // Hash the password
            $validated['password'] = bcrypt($validated['password']);
              // Generate a remember token
            $validated['remember_token'] = Str::random(10);

            $user = User::create($validated);


            return $user;
        
            
        }


        public function login(AuthRequest $request)
        {
    
            $user = User::where('email', $request->email)->first();

            
    
            if (!$user || !Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            }
    
            $response = [
                "user" => $user,
                "token" => $user->createToken($request->email)->plainTextToken
            ];
    
            return $response;
            
        }


        
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        $response = [
            'message' => 'logout',
        ];
        return $response;
    }
    
    
}
