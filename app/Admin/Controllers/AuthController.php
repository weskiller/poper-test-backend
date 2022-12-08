<?php

namespace App\Admin\Controllers;

use App\Models\Admin;
use App\Services\OAuthService;
use Encore\Admin\Controllers\AuthController as BaseAuthController;

class AuthController extends BaseAuthController
{
    public function accessToken()
    {
        /** @var Admin $user */
        $user = auth()->user();
        return OAuthService::fromIdentity('administrator')->authorize($user->username, 'admin')->json();
    }
}
