<?php

namespace Flooris\XelionClient\Model;

use Carbon\Carbon;

class XelionApiAuthModel
{
    public string $authentication;
    public Carbon $validUntil;
    public string $version;
    public string $serverVersion;
    public string $buildNumber;

    public function __construct($item)
    {
        $this->authentication = $item['authentication'];
        $this->version        = $item['version'];
        $this->serverVersion  = $item['serverVersion'];
        $this->buildNumber    = $item['buildNumber'];
        $this->validUntil     = Carbon::parse($item['validUntil']);
    }
}
