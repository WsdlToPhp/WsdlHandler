<?php

declare(strict_types=1);

namespace WsdlToPhp\WsdlHandler\Tag;

use WsdlToPhp\WsdlHandler\AbstractDocument;
use WsdlToPhp\WsdlHandler\Tag\TagRestriction as Restriction;

class Tag extends AbstractTag
{
    public function hasRestrictionChild(): bool
    {
        return $this->getFirstRestrictionChild() instanceof Restriction;
    }

    public function getFirstRestrictionChild(): ?TagRestriction
    {
        return $this->getChildByNameAndAttributes(AbstractDocument::TAG_RESTRICTION, []);
    }

    /**
     * Checks if the given tag is the same direct parent of this current tag.
     */
    public function isTheParent(AbstractTag $tag): bool
    {
        $parent = $this->getSuitableParent();

        return $parent ? $parent->getNode()->isSameNode($tag->getNode()) : false;
    }
}
