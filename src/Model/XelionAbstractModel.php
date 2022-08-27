<?php

namespace Flooris\XelionClient\Model;

abstract class XelionAbstractModel
{
    public function getItemObjectValue(array $item, string $key, $defaultValue = null): mixed
    {
        if (! isset($item['object'])) {
            return $defaultValue;
        }

        if (isset($item['object'][$key])) {
            return $item['object'][$key];
        }

        return $defaultValue;
    }

    public function getItemObjectChildOid(array $item, string $key, $defaultValue = null): ?string
    {
        if (! isset($item['object'])) {
            return $defaultValue;
        }

        if (isset($item['object'][$key]) &&
            isset($item['object'][$key]['oid'])
        ) {
            return $item['object'][$key]['oid'];
        }

        return $defaultValue;
    }
}
