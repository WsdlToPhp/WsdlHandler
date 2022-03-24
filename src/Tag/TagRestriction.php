<?php

declare(strict_types=1);

namespace WsdlToPhp\WsdlHandler\Tag;

use WsdlToPhp\WsdlHandler\AbstractDocument;

class TagRestriction extends Tag
{
    public const ATTRIBUTE_BASE = 'base';

    public function isEnumeration(): bool
    {
        return 0 < count($this->getEnumerations());
    }

    public function getEnumerations(): array
    {
        return $this->getChildrenByName(AbstractDocument::TAG_ENUMERATION);
    }

    public function getAttributeBase(): string
    {
        return $this->hasAttributeBase() ? $this->getAttribute(self::ATTRIBUTE_BASE)->getValue() : '';
    }

    public function hasAttributeBase(): bool
    {
        return $this->hasAttribute(self::ATTRIBUTE_BASE);
    }

    public function hasUnionParent(): bool
    {
        return $this->getSuitableParent(false, [
            AbstractDocument::TAG_UNION,
        ], self::MAX_DEEP, true) instanceof TagUnion;
    }
}
