<?php

declare(strict_types=1);

namespace WsdlToPhp\WsdlHandler\Tag;

use WsdlToPhp\DomHandler\AttributeHandler;
use WsdlToPhp\WsdlHandler\AbstractDocument;

class TagPart extends Tag
{
    const ATTRIBUTE_ELEMENT = 'element';
    const ATTRIBUTE_TYPE = 'type';

    /**
     * @param bool $returnValue
     * @return AttributeHandler|string|int|null
     */
    public function getAttributeElement(bool $returnValue = true)
    {
        return $this->getAttributeMixedValue(self::ATTRIBUTE_ELEMENT, $returnValue);
    }

    /**
     * @param bool $returnValue
     * @return AttributeHandler|string|int|null
     */
    public function getAttributeType(bool $returnValue = true)
    {
        return $this->getAttributeMixedValue(self::ATTRIBUTE_TYPE, $returnValue);
    }

    /**
     * @param string $attributeName
     * @param bool $returnValue
     * @return AttributeHandler|string|int|null
     */
    protected function getAttributeMixedValue(string $attributeName, bool $returnValue = true)
    {
        $value = $this->getAttribute($attributeName);
        if ($returnValue) {
            $value = $value instanceof AttributeHandler ? $value->getValue() : null;
        }

        return $value;
    }

    public function getFinalType(): string
    {
        $type = $this->getAttributeType();
        if (empty($type)) {
            $elementName = $this->getAttributeElement();
            if (!empty($elementName)) {
                $element = $this->getDomDocumentHandler()->getElementByNameAndAttributes(AbstractDocument::TAG_ELEMENT, [
                    'name' => $elementName,
                ], true);
                if ($element instanceof TagElement && $element->hasAttribute(self::ATTRIBUTE_TYPE)) {
                    $type = $element->getAttribute(self::ATTRIBUTE_TYPE)->getValue();
                } else {
                    $type = $elementName;
                }
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
        if (!empty($attribute)) {
            return $attribute->getValueNamespace();
        }

        $attribute = $this->getAttributeElement(false);
        if (!empty($attribute)) {
            return $attribute->getValueNamespace();
        }

        return null;
    }
}
