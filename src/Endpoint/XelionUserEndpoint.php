<?php

namespace Flooris\XelionClient\Endpoint;

use Psr\Http\Message\ResponseInterface;
use Flooris\XelionClient\Model\XelionApiUserModel;

class XelionUserEndpoint extends AbstractEndpoint
{
    private const ENDPOINT = "users";

    public function getUsersAsResponse(int $pageSize = 100, ?string $lastObjectId = null): ResponseInterface
    {
        $query = ['limit' => $pageSize];

        if ($lastObjectId) {
            $query['after'] = $lastObjectId;
        }

        return $this->getConnector()->get($this->getEndpointUri(), $query);
    }

    public function getUserAsResponse(string $objectId): ResponseInterface
    {
        return $this->getConnector()->get($this->getEndpointUri($objectId));
    }

    public function getEndpointUri(?string $objectId = null): string
    {
        if ($objectId) {
            return self::ENDPOINT . "/{$objectId}";
        }

        return self::ENDPOINT;
    }
}
