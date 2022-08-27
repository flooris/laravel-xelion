<?php

namespace Flooris\XelionClient\HttpClient;

use App\Models\XelionApiCredential;
use Flooris\XelionClient\XelionApi;
use Flooris\XelionClient\Model\XelionApiAuthModel;
use Flooris\XelionClient\Model\XelionApiCredentialsModel;

class XelionApiAuthenticator
{
    public function __construct(
        private readonly XelionApiCredentialsModel $credentials,
        private readonly XelionAbstractConnector   $connector
    )
    {
    }

    public function getAuthModel(): XelionApiAuthModel
    {
        $client = new XelionApi($this->connector);

        $response = $client->auth()->auth(
            $this->credentials->userName,
            $this->credentials->password,
            $this->credentials->tenant,
        );

        $dataAsJson = $response->getBody()->getContents();

        $authItem = json_decode($dataAsJson, true);

        return new XelionApiAuthModel($authItem);
    }
}
