<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Auth\AuthService;

class LoginController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = $this->authService->login(
            $request->only('email', 'password'),
            $request->ip()
        );

        return response()->json($user);
    }

    public function logout(Request $request)
    {
        $this->authService->logout();
        return response()->json(['message' => 'Logged out successfully.']);
    }
}
