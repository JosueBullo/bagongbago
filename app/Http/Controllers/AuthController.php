<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\View;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'customer',
            'status' => 'active',
        ]);

        return response()->json(['user' => $user], 201);
    }

    public function listUsers()
    {
        $users = User::all();
        return View::make('users.index', ['users' => $users]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
    
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid login details'], 401);
        }
    
        $user = $request->user();
    
        if ($user->status !== 'active') {
            return response()->json(['message' => 'This account is deactivated'], 403);
        }
    
        $token = $user->createToken('authToken')->plainTextToken;
    
        $response = [
            'user' => $user,
            'token' => $token,
            'redirect_url' => $user->role === 'customer' ? url('/customer') : url('/customer/dashboard')
        ];
    
        return response()->json($response);
    }
    
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out']);
    }
}
