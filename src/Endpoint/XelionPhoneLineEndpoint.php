<?php

namespace Flooris\XelionClient\Endpoint;

use Psr\Http\Message\ResponseInterface;
use Flooris\XelionClient\Model\XelionApiUserModel;

class XelionPhoneLineEndpoint extends AbstractEndpoint
{
    private const ENDPOINT = "phonelines";

    public function getPhoneLinesAsResponse(int $pageSize = 100, ?string $lastObjectId = null): ResponseInterface
    {
        $query = ['limit' => $pageSize];

        if ($lastObjectId) {
            $query['after'] = $lastObjectId;
        }

        return $this->getConnector()->get($this->getEndpointUri(), $query);
    }

    public function getPhoneLineAsResponse(string $objectId): ResponseInterface
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
