<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\DTO\AuthDTO;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService) {}

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $authDTO = new AuthDTO($request->email, $request->password);
        $result = $this->authService->login($authDTO->email, $authDTO->password);

        if (!$result) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        return response()->json($result);
    }

    public function logout()
    {
        $this->authService->logout();

        return response()->json(['message' => 'Logged out successfully']);
    }
}
