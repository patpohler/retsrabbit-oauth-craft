<?php

namespace Dukt\OAuth\OAuth2\Client\Provider;

use League\Oauth2\Client\Entity\User;

class RetsRabbit extends \League\OAuth2\Client\Provider\AbstractProvider
{
    private $options = [];

    public function __construct(array $options)
    {
        $this->options = $options;
    }

    public function urlAuthorize()
    {
        return 'https://api.retsrabbit.com/oauth/authorize';
    }
    
    public function urlAccessToken()
    {
        return 'https://api.retsrabbit.com/oauth/access_token';
    }

    public function urlUserDetails(\League\OAuth2\Client\Token\AccessToken $token)
    {
        return 'https://api.retsrabbit.com/v1/server?access_token='.$token;
    }

    public function userDetails($response, \League\OAuth2\Client\Token\AccessToken $token)
    {
        $user = new User;
        return $user;
    }
}