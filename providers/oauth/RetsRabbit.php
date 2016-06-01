<?php

namespace Dukt\OAuth\Providers;

use Craft\UrlHelper;
use Craft\Oauth_TokenModel;
use Guzzle\Http\Client;

class RetsRabbit extends BaseProvider {

    public function getName()
    {
        return 'Rets Rabbit';
    }

    public function getIconUrl()
    {
        return UrlHelper::getResourceUrl('retsrabbit/icon.svg');
    }

    public function getOauthVersion()
    {
        return 2;
    }

    public function getManagerUrl()
    {
        return 'https://dashboard.retsrabbit.com';
    }

    public function getScopeDocsUrl()
    {
        return 'https://retsrabbit.com/docs';

    }

    public function createProvider()
    {
        $config = [
            'clientId' => $this->providerInfos->clientId,
            'clientSecret' => $this->providerInfos->clientSecret,
            'grant_type' => 'client_credentials',
            'redirectUri' => $this->getRedirectUri(),
        ];
        return new \Dukt\OAuth\OAuth2\Client\Provider\RetsRabbit($config);
    }

    public function createSubscriber(Oauth_TokenModel $token)
    {
        $infos = $this->getInfos();

        return new \Dukt\OAuth\Guzzle\Subscribers\RetsRabbit([
            'access_token' => $token->accessToken,
        ]);
    }

    public function connectOauth2($options)
    {
        $token = false;

        // source oauth provider
        $oauthProvider = $this->getProvider();

        // google cancel
        if(\Craft\craft()->request->getParam('error'))
        {
            throw new \Exception("An error occured: ".\Craft\craft()->request->getParam('error'));
        }

        $access_url = $oauthProvider->urlAccessToken();
        $client = new Client();
        $response = $client->post($access_url)
                            ->setPostField('grant_type', 'client_credentials')
                            ->setPostField('client_id', $this->providerInfos->clientId)
                            ->setPostField('client_secret', $this->providerInfos->clientSecret)
                            ->send();

        $data = json_decode($response->getBody(true), true);

        $tokens = \Craft\craft()->oauth->getTokensByProvider('retsrabbit');

        if(sizeof($tokens) > 0) {
            $token = $tokens[0];
            $token->accessToken = $data['access_token'];
            $token->endOfLife = time() + ((int) $data['expires_in']);
        } else {
            $token = new \League\OAuth2\Client\Token\AccessToken($data);
        }

        return $token;
    }
}