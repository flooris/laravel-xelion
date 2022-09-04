<?php

namespace Flooris\XelionClient\ModelPaginator;

use Flooris\XelionClient\Model\XelionApiUserModel;
use Flooris\XelionClient\HttpClient\XelionApiConnector;

class XelionUserPaginator extends XelionAbstractPaginator
{
    public function __construct(
        private readonly XelionApiConnector $connector,
        private readonly int                $pageSize = 100,
    )
    {
        parent::__construct($this->connector, $this->pageSize);

        $this->modelClass = XelionApiUserModel::class;
        $this->endpoint   = $this->client->user();
    }
}
