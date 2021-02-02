<?php

declare(strict_types=1);

namespace WsdlToPhp\WsdlHandler\Tag;

use WsdlToPhp\WsdlHandler\AbstractDocument;

class TagEnumeration extends Tag
{
    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->getValueAttributeValue(true);
    }

    public function getRestrictionParent(): ?TagRestriction
    {
        return $this->getStrictParent(AbstractDocument::TAG_RESTRICTION);
    }

    public function getRestrictionParentType(): string
    {
        /** @var null|TagRestriction $restrictionParent */
        $restrictionParent = $this->getRestrictionParent();

        return $restrictionParent ? $restrictionParent->getAttributeBase() : '';
    }
}
