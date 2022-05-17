<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class LoginCallback extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($provider)
    {
        $oauthUser = Socialite::driver($provider)->user();
        $user = User::where('email', $oauthUser->email)->first();

        if (!$user) {
            $user = $this->createUser($oauthUser, $provider);
        } else {
            if ($user->provider !== $provider || $user->provider_id !== $oauthUser->id) {
                session()->flash('error', 'Email was taken by other user');

                return redirect($this->continueUrl());
            }

            $user = $this->updateExistsUser($user, $oauthUser, $provider);
        }

        Auth::login($user, true);

        return redirect($this->continueUrl());
    }

    protected function continueUrl()
    {
        $redirect = session()->pull('login:redirect');

        return parse_url($redirect, PHP_URL_PATH) ?: '/';
    }

    protected function createUser($oauthUser, $provider)
    {
        return User::create([
            'name'         => $oauthUser->name,
            'username'     => $oauthUser->name,
            'email'        => $oauthUser->email,
            'avatar_url'   => $oauthUser->avatar,
            'access_token' => $oauthUser->token,
            'provider_id'  => $oauthUser->id,
            'provider'  => $provider,
        ]);
    }

    protected function updateExistsUser($user, $oauthUser, $provider)
    {
        $user->update([
            'name'         => $oauthUser->name,
            'username'     => $oauthUser->name,
            'avatar_url'   => $oauthUser->avatar,
            'access_token' => $oauthUser->token,
            'provider_id'  => $oauthUser->id,
            'provider'  => $provider,
        ]);

        return $user;
    }
}
