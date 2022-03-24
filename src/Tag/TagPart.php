<?php

declare(strict_types=1);

namespace WsdlToPhp\WsdlHandler\Tag;

use WsdlToPhp\DomHandler\AttributeHandler;
use WsdlToPhp\WsdlHandler\AbstractDocument;

class TagPart extends Tag
{
    public const ATTRIBUTE_ELEMENT = 'element';
    public const ATTRIBUTE_TYPE = 'type';

    /**
     * @return null|AttributeHandler|int|string
     */
    public function getAttributeElement(bool $returnValue = true)
    {
        return $this->getAttributeMixedValue(self::ATTRIBUTE_ELEMENT, $returnValue);
    }

    public function getMatchingElement(): ?TagElement
    {
        $element = null;
        $elementName = $this->getAttributeElement();
        if (!empty($elementName)) {
            $element = $this->getDomDocumentHandler()->getElementByNameAndAttributes(AbstractDocument::TAG_ELEMENT, [
                'name' => $elementName,
            ], true);
        }

        return $element;
    }

    /**
     * @return null|AttributeHandler|int|string
     */
    public function getAttributeType(bool $returnValue = true)
    {
        return $this->getAttributeMixedValue(self::ATTRIBUTE_TYPE, $returnValue);
    }

    public function getFinalType(): string
    {
        $type = $this->getAttributeType();
        if (empty($type)) {
            $element = $this->getMatchingElement();
            if ($element instanceof TagElement && $element->hasAttribute(self::ATTRIBUTE_TYPE)) {
                $type = $element->getAttribute(self::ATTRIBUTE_TYPE)->getValue();
            } else {
                $type = $this->getAttributeElement();
            }
        }

        return $type;
    }

    public function getFinalName(): string
    {
        $name = $this->getAttributeType();
        if (empty($name)) {
            $name = $this->getAttributeElement();
        }

        return $name;
    }

    public function getFinalNamespace(): ?string
    {
        $attribute = $this->getAttributeType(false);
        if ($attribute instanceof AttributeHandler && !empty($namespace = $attribute->getValueNamespace())) {
            return $namespace;
        }

        $attribute = $this->getAttributeElement(false);
        if ($attribute instanceof AttributeHandler && !empty($namespace = $attribute->getValueNamespace())) {
            return $namespace;
        }

        return null;
    }

    /**
     * @return null|AttributeHandler|int|string
     */
    protected function getAttributeMixedValue(string $attributeName, bool $returnValue = true)
    {
        $value = $this->getAttribute($attributeName);
        if ($returnValue) {
            $value = $value instanceof AttributeHandler ? $value->getValue() : null;
        }

        return $value;
    }
}
