<?php

namespace Flooris\XelionClient\Model;

class XelionApiTelecomAddressModel extends XelionAbstractModel
{
    public ?string $objectId;
    public string $objectType;
    public string $addressType;
    public string $address;
    public string $label;
    public string $orderNumber;
    public string $commonName;
    public int $addressLength;

    public function __construct(
        private readonly array $item
    )
    {
        $this->objectId      = $this->item['oid'];
        $this->objectType    = $this->item['objectType'];
        $this->commonName    = $this->item['commonName'];
        $this->addressType   = $this->item['objectType'];
        $this->address       = $this->item['address'];
        $this->addressLength = strlen($this->item['address']);
        $this->label         = $this->item['label'];
        $this->orderNumber   = $this->item['orderNumber'];
    }
}
