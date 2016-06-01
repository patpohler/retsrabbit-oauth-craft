<?php

namespace Dukt\OAuth\Guzzle\Subscribers;

use Guzzle\Common\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class RetsRabbit implements EventSubscriberInterface
{
    private $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public static function getSubscribedEvents()
    {
        return [
            'request.before_send' => 'onRequestBeforeSend'
        ];
    }

    public function onRequestBeforeSend(Event $event)
    {
        $accessToken = $this->config['access_token'];
        $event['request']->getQuery()->set('access_token', $accessToken);
    }
}