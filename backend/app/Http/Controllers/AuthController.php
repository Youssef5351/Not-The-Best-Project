<?php
namespace App\Http\Controllers;

use App\Http\Requests\SignupRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
public function signup(SignupRequest $request)
{
    \Log::info('Received signup request:', $request->all());
     \Log::info('Signup endpoint reached');

    DB::beginTransaction();
    try {
        \Log::info('Signup attempt', $request->all());
        $data = $request->validated();

        \Log::info('Validated signup data:', $data);

        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        $token = $user->createToken('main')->plainTextToken;

        \Log::info('User created successfully:', ['user_id' => $user->id]);

        DB::commit();

        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 201);
    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('Signup error: '.$e->getMessage(), [
            'request_data' => $request->all(),
            'exception' => $e,
        ]);
        return response()->json(['error' => 'Signup failed: '.$e->getMessage()], 500);
    }
}

    
    public function login(LoginRequest $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'user' => $user,
                'token' => $token,
            ]);
        }

        return response()->json([
            'message' => 'Invalid login credentials'
        ], 401);
    }
}
