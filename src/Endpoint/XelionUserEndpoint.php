<?php

namespace Flooris\XelionClient\Endpoint;

class XelionUserEndpoint extends AbstractEndpoint
{
    private const ENDPOINT = "users";

    public function getEndpointUri(?string $objectId = null): string
    {
        if ($objectId) {
            return self::ENDPOINT . "/{$objectId}";
        }

        return self::ENDPOINT;
    }
}
