<?php

declare(strict_types=1);

namespace WsdlToPhp\WsdlHandler\Tag;

use WsdlToPhp\WsdlHandler\AbstractDocument;

class TagList extends Tag
{
    public const ATTRIBUTE_ITEM_TYPE = 'itemType';

    public function getAttributeItemType(): string
    {
        return $this->hasAttribute(self::ATTRIBUTE_ITEM_TYPE) ? $this->getAttribute(self::ATTRIBUTE_ITEM_TYPE)->getValue() : '';
    }

    public function getItemType(): string
    {
        $itemType = $this->getAttributeItemType();
        // this means this is its simpleType's restriction child element that defines its type
        if (empty($itemType)) {
            $child = $this->getChildByNameAndAttributes(AbstractDocument::TAG_RESTRICTION, []);
            if ($child instanceof TagRestriction && $child->hasAttributeBase()) {
                $itemType = $child->getAttributeBase();
            }
        }

        return $itemType;
    }
}
