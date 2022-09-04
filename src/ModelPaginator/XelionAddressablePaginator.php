<?php

namespace Flooris\XelionClient\ModelPaginator;

use Flooris\XelionClient\HttpClient\XelionApiConnector;
use Flooris\XelionClient\Model\XelionApiAddressableModel;

class XelionAddressablePaginator extends XelionAbstractPaginator
{
    public function __construct(
        private readonly XelionApiConnector $connector,
        private readonly int                $pageSize = 100,
    )
    {
        parent::__construct($this->connector, $this->pageSize);

        $this->modelClass = XelionApiAddressableModel::class;
        $this->endpoint   = $this->client->addressable();
    }
}
