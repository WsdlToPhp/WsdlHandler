<?php

declare(strict_types=1);

namespace WsdlToPhp\WsdlHandler\Tag;

class TagMessage extends Tag
{
    public function getPart(string $name): ?TagPart
    {
        return $this->getChildByNameAndAttributes('part', [
            'name' => $name,
        ]);
    }
}
