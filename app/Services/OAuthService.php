<?php

namespace App\Services;

use App\Models\OAuth\Client;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Laravel\Passport\RefreshTokenRepository;

class OAuthService
{
    public string $url = 'http://127.0.0.1/oauth/token';

    public function __construct(protected Client $client)
    {
    }

    public function authorize(string $email, string $password): Response
    {
        $data = [
            'grant_type' => 'password',
            'client_id' => $this->client->id,
            'client_secret' => $this->client->secret,
            'username' => $email,
            'password' => $password,
        ];
        return Http::asForm()->post($this->url, $data);
    }

    public function refresh(string $refreshToken): Response
    {
        $data = [
            'grant_type' => 'refresh__token',
            'client_id' => $this->client->id,
            'client_secret' => $this->client->secret,
            'refresh_token' => $refreshToken
        ];
        return Http::asForm()->post($this->url, $data);
    }

    public function revoke(string $refreshToken): void
    {
        app(RefreshTokenRepository::class)->revokeRefreshTokensByAccessTokenId($refreshToken);
    }
}
