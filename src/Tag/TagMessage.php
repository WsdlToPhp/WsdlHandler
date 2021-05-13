<?php

declare(strict_types=1);

namespace WsdlToPhp\WsdlHandler\Tag;

use WsdlToPhp\WsdlHandler\AbstractDocument;

class TagMessage extends Tag
{
    public function getPart(string $name): ?TagPart
    {
        return $this->getChildByNameAndAttributes(AbstractDocument::TAG_PART, [
            'name' => $name,
        ]);
    }
}
