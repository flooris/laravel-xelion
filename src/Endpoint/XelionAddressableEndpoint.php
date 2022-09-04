<?php

namespace Flooris\XelionClient\Endpoint;

class XelionAddressableEndpoint extends AbstractEndpoint
{
    private const ENDPOINT = "addressables";

    public function getEndpointUri(?string $objectId = null): string
    {
        if ($objectId) {
            return self::ENDPOINT . "/{$objectId}";
        }

        return self::ENDPOINT;
    }
}
