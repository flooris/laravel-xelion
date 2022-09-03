<?php

namespace Flooris\XelionClient\Model;

use Illuminate\Support\Collection;

class XelionApiPhoneLineModel extends XelionAbstractModel
{
    public ?string $objectId;
    public string $objectType;
    public Collection $phoneCollection;
    public Collection $telecomAddressCollection;

    public function __construct(
        private readonly array $item
    )
    {
        $this->objectId   = $this->getItemObjectValue($this->item, 'oid');
        $this->objectType = $this->getItemObjectValue($this->item, 'objectType');

        $this->telecomAddressCollection = collect();

        $extensions = $this->getItemObjectValue($this->item, 'extensions');
        if (is_array($extensions) && count($extensions)) {
            foreach ($extensions as $extension) {
                $this->telecomAddressCollection->push(new XelionApiTelecomAddressModel($extension));
            }
        }

        $this->phoneCollection = collect();

        $phones = $this->getItemObjectValue($this->item, 'phones');
        if (is_array($phones) && count($phones)) {
            foreach ($phones as $phone) {
                $this->phoneCollection->push(new XelionApiPhoneModel($phone));
            }
        }

        //        $this->primaryPhoneLineOid = $this->getItemObjectChildOid($this->item, 'primaryLine');
    }

    public function getPhoneNumbers(): Collection
    {
        return $this->telecomAddressCollection->pluck('address');
    }

    public function getInternalPhoneNumber(): ?string
    {
        return $this->telecomAddressCollection->sortBy('addressLength')->first()?->address;
    }
}
