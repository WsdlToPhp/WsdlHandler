<?php

declare(strict_types=1);

namespace WsdlToPhp\WsdlHandler\Tag;

use WsdlToPhp\DomHandler\AbstractNodeHandler;
use WsdlToPhp\WsdlHandler\AbstractDocument;

class TagDocumentation extends Tag
{
    public function getContent(): string
    {
        return $this->getNodeValue();
    }

    /**
     * Finds parent node of this documentation node without taking care of the name attribute for enumeration.
     * This case is managed first because enumerations are contained by elements and
     * the method could climb to its parent without stopping on the enumeration tag.
     * Indeed, depending on the node, it may contain or not the attribute named "name" so we have to split each case.
     */
    public function getSuitableParent(bool $checkName = true, array $additionalTags = [], int $maxDeep = self::MAX_DEEP, bool $strict = false): ?AbstractNodeHandler
    {
        if (!$strict) {
            $enumerationTag = $this->getStrictParent(AbstractDocument::TAG_ENUMERATION);
            if ($enumerationTag instanceof TagEnumeration) {
                return $enumerationTag;
            }
        }

        return parent::getSuitableParent($checkName, $additionalTags, $maxDeep, $strict);
    }

    public function getSuitableParentTags(array $additionalTags = []): array
    {
        return parent::getSuitableParentTags(array_merge($additionalTags, [
            AbstractDocument::TAG_OPERATION,
            AbstractDocument::TAG_ATTRIBUTE_GROUP,
        ]));
    }
}
