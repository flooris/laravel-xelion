<?php

namespace Flooris\XelionClient\Endpoint;

class XelionPhoneLineEndpoint extends AbstractEndpoint
{
    private const ENDPOINT = "phonelines";

    public function getEndpointUri(?string $objectId = null): string
    {
        if ($objectId) {
            return self::ENDPOINT . "/{$objectId}";
        }

        return self::ENDPOINT;
    }
}
