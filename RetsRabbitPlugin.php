<?php
namespace Craft;

require_once(CRAFT_PLUGINS_PATH.'retsrabbit/vendor/autoload.php');

class RetsRabbitPlugin extends BasePlugin
{
    /**
     * Get Name
     */
    function getName()
    {
        return Craft::t('Rets Rabbit');
    }

    public function getVersion()
    {
        return '1.0.0';
    }

    public function getDeveloper()
    {
        return 'Rets Rabbit';
    }

    public function getDeveloperUrl()
    {
        return 'https://www.retsrabbit.com/';
    }

    /**
     * Get OAuth providers
     */
    public function getOauthProviders()
    {
        return [
            'Dukt\OAuth\Providers\RetsRabbit'
        ];
    }

}