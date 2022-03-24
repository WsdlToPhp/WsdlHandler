<?php

declare(strict_types=1);

namespace WsdlToPhp\WsdlHandler\Tag;

use WsdlToPhp\DomHandler\AbstractAttributeHandler as Attribute;
use WsdlToPhp\WsdlHandler\AbstractDocument;

class TagHeader extends AbstractTagOperationElement
{
    public const ATTRIBUTE_PART = 'part';
    public const REQUIRED_HEADER = 'required';
    public const OPTIONAL_HEADER = 'optional';
    public const ATTRIBUTE_REQUIRED = 'wsdl:required';

    public function getParentInput(): ?TagInput
    {
        return $this->getStrictParent(AbstractDocument::TAG_INPUT);
    }

    public function getAttributeRequired(): bool
    {
        return $this->hasAttribute(self::ATTRIBUTE_REQUIRED) ? $this->getAttribute(self::ATTRIBUTE_REQUIRED)->getValue(true, true, 'bool') : true;
    }

    public function getAttributeNamespace(): string
    {
        return $this->hasAttribute(Attribute::ATTRIBUTE_NAMESPACE) ? $this->getAttribute(Attribute::ATTRIBUTE_NAMESPACE)->getValue() : '';
    }

    public function getAttributePart(): string
    {
        return $this->hasAttribute(self::ATTRIBUTE_PART) ? $this->getAttribute(self::ATTRIBUTE_PART)->getValue() : '';
    }

    public function getPartTag(): ?TagPart
    {
        return $this->getPart($this->getAttributePart());
    }

    public function getHeaderType(): string
    {
        $part = $this->getPartTag();

        return $part instanceof TagPart ? $part->getFinalType() : '';
    }

    public function getHeaderName(): string
    {
        $part = $this->getPartTag();

        return $part instanceof TagPart ? $part->getFinalName() : '';
    }

    public function getHeaderNamespace(): string
    {
        $namespace = $this->getHeaderNamespaceFromPart();
        if (empty($namespace)) {
            $namespace = $this->getHeaderNamespaceFromMessage();
        }

        return $namespace;
    }

    public function getHeaderRequired(): string
    {
        return $this->getAttributeRequired() ? self::REQUIRED_HEADER : self::OPTIONAL_HEADER;
    }

    protected function getHeaderNamespaceFromPart(): string
    {
        $part = $this->getPartTag();
        $namespace = '';
        if ($part instanceof TagPart) {
            $finalNamespace = $part->getFinalNamespace();
            if (!empty($finalNamespace)) {
                $namespace = $this->getDomDocumentHandler()->getNamespaceUri($finalNamespace);
            } elseif (($element = $part->getMatchingElement()) instanceof TagElement) {
                $namespace = $element->getTargetNamespace();
            }
        }

        return $namespace;
    }

    protected function getHeaderNamespaceFromMessage(): string
    {
        $namespace = '';
        $messageNamespace = $this->getAttributeMessageNamespace();
        if (!empty($messageNamespace)) {
            $namespace = $this->getDomDocumentHandler()->getNamespaceUri($messageNamespace);
        }

        return $namespace;
    }
}
