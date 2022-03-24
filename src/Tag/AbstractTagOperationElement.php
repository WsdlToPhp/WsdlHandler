<?php

declare(strict_types=1);

namespace WsdlToPhp\WsdlHandler\Tag;

use WsdlToPhp\WsdlHandler\AbstractDocument;

abstract class AbstractTagOperationElement extends Tag
{
    public const ATTRIBUTE_MESSAGE = 'message';

    public function getParentOperation(): ?TagOperation
    {
        return $this->getStrictParent(AbstractDocument::TAG_OPERATION);
    }

    public function hasAttributeMessage(): bool
    {
        return $this->hasAttribute(self::ATTRIBUTE_MESSAGE);
    }

    public function getAttributeMessage(): string
    {
        return $this->hasAttributeMessage() ? $this->getAttribute(self::ATTRIBUTE_MESSAGE)->getValue() : '';
    }

    public function getAttributeMessageNamespace(): ?string
    {
        return $this->hasAttribute(self::ATTRIBUTE_MESSAGE) ? $this->getAttribute(self::ATTRIBUTE_MESSAGE)->getValueNamespace() : null;
    }

    public function getMessage(): ?TagMessage
    {
        $message = null;
        $messageName = $this->getAttributeMessage();

        if (!empty($messageName)) {
            $message = $this->getDomDocumentHandler()->getElementByNameAndAttributes(AbstractDocument::TAG_MESSAGE, [
                'name' => $messageName,
            ], true);
        }

        return $message;
    }

    public function getParts(): ?array
    {
        $parts = null;
        $message = $this->getMessage();
        if ($message instanceof TagMessage) {
            $parts = $message->getChildrenByName(AbstractDocument::TAG_PART);
        }

        return $parts;
    }

    public function getPart(string $partName): ?TagPart
    {
        $part = null;
        $message = $this->getMessage();
        if ($message instanceof TagMessage && !empty($partName)) {
            $part = $message->getPart($partName);
        }

        return $part;
    }
}
