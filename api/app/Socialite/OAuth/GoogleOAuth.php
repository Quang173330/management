<?php

namespace App\Socialite\OAuth;

use App\Socialite\Contracts\OAuth;
use Laravel\Socialite\Contracts\Provider;
use Laravel\Socialite\Facades\Socialite;

class GoogleOAuth implements OAuth
{
    public const SCOPES = ['openid', 'profile', 'email'];

    public function getDriver(): Provider
    {
        return Socialite::driver('google')->scopes(self::SCOPES);
    }
}
