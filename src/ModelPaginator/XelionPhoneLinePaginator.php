<?php

namespace Flooris\XelionClient\ModelPaginator;

use Flooris\XelionClient\HttpClient\XelionApiConnector;
use Flooris\XelionClient\Model\XelionApiPhoneLineModel;

class XelionPhoneLinePaginator extends XelionAbstractPaginator
{
    public function __construct(
        private readonly XelionApiConnector $connector,
        private readonly int                $pageSize = 100,
    )
    {
        parent::__construct($this->connector, $this->pageSize);

        $this->modelClass = XelionApiPhoneLineModel::class;
        $this->endpoint   = $this->client->phoneLine();
    }
}
