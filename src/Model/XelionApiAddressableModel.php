<?php

namespace Flooris\XelionClient\Model;

class XelionApiAddressableModel extends XelionAbstractModel
{
    public ?string $objectId;
    public string $objectType;
    public ?string $address;
    public ?string $addressType;
    public int $orderNumber;
    public string $name;
    public ?string $commonName;
    public ?string $addressObjectId;
    public int $addressLength;

    public function __construct(
        private readonly array $item
    )
    {
        $this->objectId        = $this->getItemObjectValue($this->item, 'oid');
        $this->objectType      = $this->getItemObjectValue($this->item, 'objectType');
        $this->name            = $this->getItemObjectValue($this->item, 'commonName');
        $this->commonName      = $this->getItemObjectChildValue($this->item, 'telecomAddress', 'commonName', null);
        $this->address         = $this->getItemObjectChildValue($this->item, 'telecomAddress', 'address', null);
        $this->addressType     = $this->getItemObjectChildValue($this->item, 'telecomAddress', 'addressType', null);
        $this->addressObjectId = $this->getItemObjectChildValue($this->item, 'telecomAddress', 'oid', null);
        $this->orderNumber     = $this->getItemObjectChildValue($this->item, 'telecomAddress', 'orderNumber', 0);
        $this->addressLength   = $this->address ? strlen($this->address) : 0;
    }
}
