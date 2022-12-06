<?php

namespace App\Http\Controllers;

use App\Http\Requests\OAuth\LoginRequest;
use App\Http\Requests\OAuth\RefreshRequest;
use App\Http\Requests\OAuth\RevokeRequest;
use App\Models\OAuth\Client;
use App\Services\OAuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\UnauthorizedException;
use JetBrains\PhpStorm\NoReturn;

class AuthController
{
    public OAuthService $service;

    public function __construct(Request $request)
    {
        $this->service = new OAuthService($this->resolveClient($request));
    }

    protected function resolveClient(Request $request): Client
    {
        return Client::whereProvider(Str::plural($request->input('identity')))
            ->firstOr(fn() => throw new UnauthorizedException('authentication service is unavailable'));
    }

    public function login(LoginRequest $request)
    {
        return $this->service->authorize($request->input('email'), $request->input('password'))->json();
    }

    public function refresh(RefreshRequest $request)
    {
        return $this->service->refresh($request->input('refresh_token'))->json();
    }

    #[NoReturn]
    public function revoke(RevokeRequest $request): void
    {
        $this->service->revoke($request->input('refresh_token'));
    }
}
