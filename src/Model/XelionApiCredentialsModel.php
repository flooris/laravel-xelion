<?php

namespace Flooris\XelionClient\Model;

class XelionApiCredentialsModel
{
    public function __construct(
        public readonly string $baseUrl,
        public readonly string $userName,
        public readonly string $password,
        public readonly string $version,
        public readonly string $tenant,
        public readonly ?string $token = null,
    )
    {

    }
}
