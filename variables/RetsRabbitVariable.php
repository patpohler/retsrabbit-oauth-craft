<?php
/**
 * @link      https://dukt.net/craft/rest/
 * @copyright Copyright (c) 2016, Dukt
 * @license   https://dukt.net/craft/rest/docs#license
 */

namespace Craft;

class RetsRabbitVariable {

    public function getToken()
    {
        $tokens = craft()->oauth->getTokensByProvider('retsrabbit');
        if(sizeof($tokens) > 0) {
            $token = $tokens[0];
            $time = time();
            if($time > $token->endOfLife) {
                $provider = craft()->oauth->getProvider('retsrabbit');

                $newtoken = $provider->connect([]);
                craft()->oauth->saveToken($newtoken);
                return $newtoken;
            } else {
                return craft()->oauth->getTokenById($token->id);
            }
        }

        return null;
    }
}