<?php

namespace App\Http\Controllers;

use App\Http\Requests\OAuth\LoginRequest;
use App\Http\Requests\OAuth\RefreshRequest;
use App\Http\Requests\OAuth\ValidateRequest;
use App\Services\OAuthService;

class AuthController
{
    public function login(LoginRequest $request)
    {
        return OAuthService::fromIdentity($request->input('identity'))
            ->authorize($request->input('email'), $request->input('password'))
            ->json();
    }

    public function refresh(RefreshRequest $request)
    {
        return OAuthService::fromIdentity($request->input('identity'))
            ->refresh($request->input('refresh_token'))
            ->json();
    }

    public function validate(ValidateRequest $request)
    {
    }
}
