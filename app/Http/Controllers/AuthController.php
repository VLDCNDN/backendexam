<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => ['required'],
            'password' => ['required']
        ]);

        $user = User::where('username', $request->username)->first();
        
        if (!$user || !Hash::check($request->password, $user->password)) {
            Log::error("Login", ["message" => "Unauthorized", "user" => $request->username]);
            throw ValidationException::withMessages([
                'username' => ['The provided credentials are incorrect'],
            ]);
        }

        Log::info("Login", ["message" => "Authenticated", "user" => $request->username]);

        $this->setRedis("user:{$user->username}", $user);
        $token = $user->createToken($request->username)->plainTextToken;
        return response(['user' => $user, 'token' => $token], Response::HTTP_OK);
    }

    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => ['required', 'string'],
            'username' => ['required', 'string', 'min:6', 'max:64', 'unique:users'],
            'password' => ['required'],
            'company' => ['required'],
            'follower_count' => ['integer'],
            'public_repository_count' => ['integer']
        ]);

        $fields['password'] = bcrypt($fields['password']);

        $user = User::create($fields);

        if (!$user) {
            Log::error("Register", ["message" => "Failed", "user" => $fields['username']]);
            return response(["message" => "Error Saving"], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $this->setRedis("user:{$user->username}", $user);
        $token = $user->createToken($user->username)->plainTextToken;
        Log::info("Register", ["message" => "Created", "user" => $fields['username']]);

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, Response::HTTP_CREATED);
    }
}
