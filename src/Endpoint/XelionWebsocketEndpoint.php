<?php

namespace Flooris\XelionClient\Endpoint;

use Psr\Http\Message\ResponseInterface;
use Flooris\XelionClient\Model\XelionApiUserModel;

class XelionWebsocketEndpoint extends AbstractEndpoint
{
    private const ENDPOINT = "me/websocket";

    public function getWebsocketUrl(): string
    {
        $response = $this->getConnector()->post(self::ENDPOINT, null);

        $dataAsJson = $response->getBody()->getContents();

        $resultArray = json_decode($dataAsJson, true);

        return $resultArray['object'];
    }
}
