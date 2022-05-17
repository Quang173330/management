<?php

namespace App\Socialite\Contracts;

use Laravel\Socialite\Contracts\Provider;

interface OAuth
{
    public function getDriver(): Provider;
}
