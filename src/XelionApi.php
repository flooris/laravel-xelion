<?php

namespace Flooris\XelionClient;

use Flooris\XelionClient\Endpoint\XelionUserEndpoint;
use Flooris\XelionClient\Endpoint\XelionAuthEndpoint;
use Flooris\XelionClient\Endpoint\XelionWebsocketEndpoint;
use Flooris\XelionClient\Endpoint\XelionPhoneLineEndpoint;
use Flooris\XelionClient\HttpClient\XelionAbstractConnector;

class XelionApi
{
    public function __construct(
        private readonly XelionAbstractConnector $connector
    )
    {
    }

    public function getConnector(): XelionAbstractConnector
    {
        return $this->connector;
    }

    public function auth(): XelionAuthEndpoint
    {
        return new XelionAuthEndpoint($this);
    }

    public function user(): XelionUserEndpoint
    {
        return new XelionUserEndpoint($this);
    }

    public function phoneLine(): XelionPhoneLineEndpoint
    {
        return new XelionPhoneLineEndpoint($this);
    }

    public function webSocket(): XelionWebsocketEndpoint
    {
        return new XelionWebsocketEndpoint($this);
    }
}
