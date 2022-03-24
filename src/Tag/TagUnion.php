<?php

declare(strict_types=1);

namespace WsdlToPhp\WsdlHandler\Tag;

use WsdlToPhp\WsdlHandler\AbstractDocument;

class TagUnion extends Tag
{
    public const ATTRIBUTE_MEMBER_TYPES = 'memberTypes';

    public function getAttributeMemberTypes(): array
    {
        return $this->parseMemberTypes();
    }

    public function hasMemberTypesAsChildren(): bool
    {
        return 0 < count($this->getMemberTypesChildren());
    }

    public function getMemberTypesChildren(): array
    {
        return $this->getChildrenByName(AbstractDocument::TAG_SIMPLE_TYPE);
    }

    protected function parseMemberTypes(): array
    {
        $memberTypes = [];
        $value = $this->hasAttribute(self::ATTRIBUTE_MEMBER_TYPES) ? $this->getAttribute(self::ATTRIBUTE_MEMBER_TYPES)->getValue(true) : '';
        if (!empty($value)) {
            $values = explode(' ', $value);
            foreach ($values as $val) {
                $memberTypes[] = implode('', array_slice(explode(':', $val), -1, 1));
            }
        }

        return $memberTypes;
    }
}
