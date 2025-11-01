<?php

namespace App\Http\Controllers;

use App\Http\Requests\Authentication\LoginRequest;
use App\Http\Requests\Authentication\RegisterRequest;
use App\Http\Resources\LoginResource;
use App\Services\AuthService;

class AuthController extends Controller
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $token = $this->authService->storeUser($data);

        return new LoginResource($token);
    }

    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        $token = $this->authService->login($data);

        return new LoginResource($token);
    }
}
