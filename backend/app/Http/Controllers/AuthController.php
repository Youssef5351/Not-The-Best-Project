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
        DB::beginTransaction();
        try {
            \Log::info('Signup attempt', $request->all());
            $data = $request->validated();

            $user = User::create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
            ]);
            $token = $user->createToken('main')->plainTextToken;

            DB::commit();

            return response([
                'user' => $user,
                'token' => $token,
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Signup error: '.$e->getMessage());
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
