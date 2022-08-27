<?php

namespace Flooris\XelionClient\Endpoint;

use Flooris\XelionClient\XelionApi;
use Flooris\XelionClient\HttpClient\XelionAbstractConnector;

class AbstractEndpoint
{
    public function __construct(
        private readonly XelionApi $client
    )
    {
    }

    public function getClient(): XelionApi
    {
        return $this->client;
    }

    public function getConnector(): XelionAbstractConnector
    {
        return $this->client->getConnector();
    }
}
