<?php

namespace Flooris\XelionClient\Endpoint;

use Psr\Http\Message\ResponseInterface;

class XelionAuthEndpoint extends AbstractEndpoint
{
    private const ENDPOINT = "me/login";

    public function auth(string $userName, string $password, string $tenant): ResponseInterface
    {
        $postData = [
            'userName'  => $userName,
            'password'  => $password,
            'userSpace' => $tenant,
        ];

        return $this->getConnector()->post($this->getEndpointUri(), $postData);
    }

    public function getEndpointUri(?string $objectId = null): string
    {
        return self::ENDPOINT;
    }
}
