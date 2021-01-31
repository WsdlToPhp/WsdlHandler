<?php

declare(strict_types=1);

namespace WsdlToPhp\WsdlHandler\Tag;

use WsdlToPhp\WsdlHandler\AbstractDocument;

class TagAttribute extends Tag
{
    public function getSuitableParentTags(array $additionalTags = []): array
    {
        return parent::getSuitableParentTags(array_merge($additionalTags, [
            AbstractDocument::TAG_ATTRIBUTE_GROUP,
        ]));
    }
}
