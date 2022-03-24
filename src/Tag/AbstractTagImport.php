<?php

declare(strict_types=1);

namespace WsdlToPhp\WsdlHandler\Tag;

abstract class AbstractTagImport extends Tag
{
    public const ATTRIBUTE_LOCATION = 'location';
    public const ATTRIBUTE_SCHEMA_LOCATION = 'schemaLocation';
    public const ATTRIBUTE_SCHEMA_LOCATION_ = 'schemalocation';

    public function getLocationAttributeValue(): string
    {
        $location = '';

        if ($this->hasAttribute(self::ATTRIBUTE_LOCATION)) {
            $location = $this->getAttributeValue(self::ATTRIBUTE_LOCATION, true);
        } elseif ($this->hasAttribute(self::ATTRIBUTE_SCHEMA_LOCATION)) {
            $location = $this->getAttributeValue(self::ATTRIBUTE_SCHEMA_LOCATION, true);
        } elseif ($this->hasAttribute(self::ATTRIBUTE_SCHEMA_LOCATION_)) {
            $location = $this->getAttributeValue(self::ATTRIBUTE_SCHEMA_LOCATION_, true);
        }

        if (!empty($location) && './' === mb_substr($location, 0, 2)) {
            $location = mb_substr($location, 2);
        }

        return $location;
    }
}
