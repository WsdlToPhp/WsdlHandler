<?php

declare(strict_types=1);

namespace WsdlToPhp\WsdlHandler\Tag;

use WsdlToPhp\WsdlHandler\AbstractDocument;

/**
 * @see https://www.w3.org/TR/xmlschema11-1/#element-choice
 */
class TagChoice extends Tag
{
    public function getChildrenElements(): array
    {
        $children = [];
        foreach (self::getChildrenElementsTags() as $tagName) {
            $children = array_merge($children, $this->getFilteredChildrenByName($tagName));
        }

        return $children;
    }

    public static function getChildrenElementsTags(): array
    {
        return [
            AbstractDocument::TAG_ELEMENT,
            AbstractDocument::TAG_GROUP,
            AbstractDocument::TAG_CHOICE,
            AbstractDocument::TAG_ANY,
        ];
    }

    public static function getForbiddenParentTags(): array
    {
        return [
            AbstractDocument::TAG_COMPLEX_TYPE,
            AbstractDocument::TAG_SEQUENCE,
        ];
    }

    protected function getFilteredChildrenByName(string $tagName): array
    {
        return array_filter($this->getChildrenByName($tagName), [
            $this,
            'filterFoundChildren',
        ]);
    }

    /**
     * This must ensure the current element, based on its tagName is not contained by another element than the choice.
     * If it is contained by another element, then it is child/property of its parent element and does not belong to the choice elements.
     */
    protected function filterFoundChildren(AbstractTag $child): bool
    {
        $forbiddenParentTags = self::getForbiddenParentTags();
        $valid = true;
        while ($child && $child->getParent() && !$this->getNode()->isSameNode($child->getParent()->getNode())) {
            $valid = $valid && !in_array($child->getParent()->getName(), $forbiddenParentTags);
            $child = $child->getParent();
        }

        return (bool) $valid;
    }
}
