<?php

declare(strict_types=1);

namespace WsdlToPhp\WsdlHandler;

use DOMElement;
use WsdlToPhp\DomHandler\AbstractDomDocumentHandler;
use WsdlToPhp\DomHandler\DomDocumentHandler;
use WsdlToPhp\DomHandler\ElementHandler;
use WsdlToPhp\WsdlHandler\Tag\Tag;

abstract class AbstractDocument extends DomDocumentHandler
{
    public const TAG_ADDRESS = 'address';
    public const TAG_ALL = 'all';
    public const TAG_ANNOTATION = 'annotation';
    public const TAG_ANY = 'any';
    public const TAG_ANY_ATTRIBUTE = 'anyAttribute';
    public const TAG_APPINFO = 'appinfo';
    public const TAG_ATTRIBUTE = 'attribute';
    public const TAG_ATTRIBUTE_GROUP = 'attributeGroup';
    public const TAG_BINDING = 'binding';
    public const TAG_BODY = 'body';
    public const TAG_CHOICE = 'choice';
    public const TAG_COMPLEX_CONTENT = 'complexContent';
    public const TAG_COMPLEX_TYPE = 'complexType';
    public const TAG_DEFINITIONS = 'definitions';
    public const TAG_DOCUMENTATION = 'documentation';
    public const TAG_ELEMENT = 'element';
    public const TAG_ENUMERATION = 'enumeration';
    public const TAG_EXTENSION = 'extension';
    public const TAG_FIELD = 'field';
    public const TAG_GROUP = 'group';
    public const TAG_HEADER = 'header';
    public const TAG_IMPORT = 'import';
    public const TAG_INCLUDE = 'include';
    public const TAG_INPUT = 'input';
    public const TAG_KEY = 'key';
    public const TAG_KEYREF = 'keyref';
    public const TAG_LIST = 'list';
    public const TAG_MEMBER_TYPES = 'memberTypes';
    public const TAG_MESSAGE = 'message';
    public const TAG_NOTATION = 'notation';
    public const TAG_OPERATION = 'operation';
    public const TAG_OUTPUT = 'output';
    public const TAG_PART = 'part';
    public const TAG_PORT = 'port';
    public const TAG_PORT_TYPE = 'portType';
    public const TAG_REDEFINE = 'redefine';
    public const TAG_RESTRICTION = 'restriction';
    public const TAG_SELECTOR = 'selector';
    public const TAG_SEQUENCE = 'sequence';
    public const TAG_SCHEMA = 'schema';
    public const TAG_SIMPLE_CONTENT = 'simpleContent';
    public const TAG_SIMPLE_TYPE = 'simpleType';
    public const TAG_TYPES = 'types';
    public const TAG_UNION = 'union';
    public const TAG_UNIQUE = 'unique';

    public const ATTRIBUTE_TARGET_NAMESPACE = 'targetNamespace';

    public function getNamespaceUri(string $namespace): string
    {
        $rootElement = $this->getRootElement();
        $uri = '';
        if ($rootElement instanceof ElementHandler && $rootElement->hasAttribute(sprintf('xmlns:%s', $namespace))) {
            $uri = $rootElement->getAttributeValue(sprintf('xmlns:%s', $namespace));
        }

        return $uri;
    }

    public function getAttributeTargetNamespaceValue(): string
    {
        $namespace = '';
        $rootElement = $this->getRootElement();

        if ($rootElement instanceof ElementHandler && $rootElement->hasAttribute(self::ATTRIBUTE_TARGET_NAMESPACE)) {
            $namespace = $rootElement->getAttributeValue(self::ATTRIBUTE_TARGET_NAMESPACE, true);
        }

        return $namespace;
    }

    protected function getElementHandler(DOMElement $element, AbstractDomDocumentHandler $domDocument, int $index = -1): ElementHandler
    {
        $handlerName = Tag::class;
        if (class_exists($elementNameClass = sprintf('%s\Tag\Tag%s', __NAMESPACE__, ucfirst(implode('', array_slice(explode(':', $element->nodeName), -1, 1)))))) {
            $handlerName = $elementNameClass;
        }

        return new $handlerName($element, $domDocument, $index);
    }
}
