<?php

namespace Flooris\XelionClient\Model;

class XelionApiUserModel extends XelionAbstractModel
{
    public string $objectId;
    public string $objectType;
    public string $userName;
    public string $commonName;
    public bool $active;
    public ?array $primaryPhoneLine;
    public ?string $primaryPhoneLineOid;
    public ?array $phones;
    public ?array $lines;

    public function __construct(
        private readonly array $item
    )
    {
        $this->objectId            = $this->getItemObjectValue($this->item, 'oid');
        $this->objectType          = $this->getItemObjectValue($this->item, 'objectType');
        $this->userName            = $this->getItemObjectValue($this->item, 'userName');
        $this->commonName          = $this->getItemObjectValue($this->item, 'commonName');
        $this->active              = $this->getItemObjectValue($this->item, 'active', true);
        $this->primaryPhoneLine    = $this->getItemObjectValue($this->item, 'primaryLine');
        $this->primaryPhoneLineOid = $this->getItemObjectChildOid($this->item, 'primaryLine');
    }
}
