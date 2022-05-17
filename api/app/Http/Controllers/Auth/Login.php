<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Socialite\SocialiteService;
use Illuminate\Http\Request;

class Login extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected $social;

    public function __construct(SocialiteService $socialiteService)
    {
        $this->social = $socialiteService;
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, $provider)
    {
        if ($request->query->has('continue')) {
            session()->put('login:redirect', $request->query->get('continue'));
        }

        return $this->social->oauth($provider)->getDriver()->redirect();
    }
}
