<?php

declare(strict_types=1);

namespace WsdlToPhp\WsdlHandler\Tag;

use DOMElement;
use WsdlToPhp\DomHandler\NodeHandler;
use WsdlToPhp\WsdlHandler\AbstractDocument;
use WsdlToPhp\DomHandler\AbstractAttributeHandler as Attribute;
use WsdlToPhp\DomHandler\ElementHandler;
use WsdlToPhp\DomHandler\AbstractNodeHandler;

abstract class AbstractTag extends ElementHandler
{
    const MAX_DEEP = 5;

    /**
     * This method aims to get the parent element that matches a valid Wsdl element (aka struct)
     * @param bool $checkName
     * @param array $additionalTags
     * @param int $maxDeep
     * @param bool $strict
     * @return NodeHandler|null
     */
    public function getSuitableParent(bool $checkName = true, array $additionalTags = [], int $maxDeep = self::MAX_DEEP, bool $strict = false): ?AbstractNodeHandler
    {
        $parentNode = null;
        if ($this->getParent() instanceof AbstractNodeHandler) {
            $parentTags = $strict ? $additionalTags : $this->getSuitableParentTags($additionalTags);
            $parentNode = $this->getParent()->getNode();
            while ($maxDeep-- > 0 && ($parentNode instanceof DOMElement) && !empty($parentNode->nodeName) && (!preg_match('/' . implode('|', $parentTags) . '/i', $parentNode->nodeName) || ($checkName && preg_match('/' . implode('|', $parentTags) . '/i', $parentNode->nodeName) && (!$parentNode->hasAttribute('name') || $parentNode->getAttribute('name') === '')))) {
                $parentNode = $parentNode->parentNode;
            }
            if ($parentNode instanceof DOMElement) {
                $parentNode = $this->getDomDocumentHandler()->getHandler($parentNode);
            } else {
                $parentNode = null;
            }
        }

        return $parentNode;
    }

    protected function getSuitableParentTags(array $additionalTags = []): array
    {
        return array_merge([
            AbstractDocument::TAG_ELEMENT,
            AbstractDocument::TAG_ATTRIBUTE,
            AbstractDocument::TAG_SIMPLE_TYPE,
            AbstractDocument::TAG_COMPLEX_TYPE,
        ], $additionalTags);
    }

    protected function getStrictParent(string $name, bool $checkName = false): ?AbstractNodeHandler
    {
        $parent = $this->getSuitableParent($checkName, [
            $name,
        ], self::MAX_DEEP, true);

        if ($parent instanceof AbstractNodeHandler && $parent->getName() === $name) {
            return $parent;
        }

        return null;
    }

    public function hasAttributeName(): bool
    {
        return $this->hasAttribute(Attribute::ATTRIBUTE_NAME);
    }

    public function hasAttributeRef(): bool
    {
        return $this->hasAttribute(Attribute::ATTRIBUTE_REF);
    }

    public function getAttributeName(): string
    {
        return $this->getAttribute(Attribute::ATTRIBUTE_NAME) instanceof Attribute ? $this->getAttribute(Attribute::ATTRIBUTE_NAME)->getValue() : '';
    }

    public function getAttributeRef(): string
    {
        return $this->getAttribute(Attribute::ATTRIBUTE_REF) instanceof Attribute ? $this->getAttribute(Attribute::ATTRIBUTE_REF)->getValue() : '';
    }

    public function hasAttributeValue(): bool
    {
        return $this->hasAttribute(Attribute::ATTRIBUTE_VALUE);
    }

    public function getValueAttributeValue(bool $withNamespace = false, bool $withinItsType = true, ?string $asType = null)
    {
        return $this->getAttribute(Attribute::ATTRIBUTE_VALUE) instanceof Attribute ? $this->getAttribute(Attribute::ATTRIBUTE_VALUE)->getValue($withNamespace, $withinItsType, $asType) : '';
    }
}
