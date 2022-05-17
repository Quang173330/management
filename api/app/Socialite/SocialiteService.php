<?php

namespace App\Socialite;

use InvalidArgumentException;

class SocialiteService
{
    public const SUPPORTED_PROVIDERS = ['google'];

    /**
     * @param  string $provider
     * @return \App\Git\Contracts\OAuth
     */
    public function oauth($provider)
    {
        return $this->makeSocialiteFeatureProvider($provider, 'OAuth');
    }

    /**
     * @param  string $provider
     * @param  string $feature
     * @return mixed
     */
    protected function makeSocialiteFeatureProvider($provider, $feature)
    {
        if (!in_array($provider, self::SUPPORTED_PROVIDERS)) {
            throw new InvalidArgumentException("{$provider} is not supported");
        }

        $providerClass = ucfirst($provider).$feature;

        return app("App\\Socialite\\{$feature}\\{$providerClass}");
    }
}
