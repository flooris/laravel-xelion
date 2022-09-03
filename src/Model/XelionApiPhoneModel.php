<?php

namespace Flooris\XelionClient\Model;

use Illuminate\Support\Collection;

class XelionApiPhoneModel extends XelionAbstractModel
{
    public string $objectId;
    public string $objectType;
    public string $commonName;
    public string $lineOrder;

    public function __construct(
        private readonly array $item
    )
    {
        $this->objectId   = $this->item['phone']['oid'];
        $this->objectType = $this->item['phone']['objectType'];
        $this->commonName = $this->item['phone']['commonName'];
        $this->lineOrder  = $this->item['lineOrder'];
    }
}
