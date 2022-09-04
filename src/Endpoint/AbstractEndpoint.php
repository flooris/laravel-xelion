<?php

namespace Flooris\XelionClient\Endpoint;

use Flooris\XelionClient\XelionApi;
use Psr\Http\Message\ResponseInterface;
use Flooris\XelionClient\HttpClient\XelionAbstractConnector;

abstract class AbstractEndpoint
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

    public function getSingleObjectAsResponse(string $objectId): ResponseInterface
    {
        return $this->getConnector()->get($this->getEndpointUri($objectId));
    }

    public function getObjectListAsResponse(int $pageSize = 100, ?string $lastObjectId = null): ResponseInterface
    {
        $query = ['limit' => $pageSize];

        if ($lastObjectId) {
            $query['after'] = $lastObjectId;
        }

        return $this->getConnector()->get($this->getEndpointUri(), $query);
    }

    abstract public function getEndpointUri(?string $objectId = null): string;
}
