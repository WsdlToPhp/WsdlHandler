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
    const TAG_ADDRESS = 'address';
    const TAG_ALL = 'all';
    const TAG_ANNOTATION = 'annotation';
    const TAG_ANY = 'any';
    const TAG_ANY_ATTRIBUTE = 'anyAttribute';
    const TAG_APPINFO = 'appinfo';
    const TAG_ATTRIBUTE = 'attribute';
    const TAG_ATTRIBUTE_GROUP = 'attributeGroup';
    const TAG_BINDING = 'binding';
    const TAG_BODY = 'body';
    const TAG_CHOICE = 'choice';
    const TAG_COMPLEX_CONTENT = 'complexContent';
    const TAG_COMPLEX_TYPE = 'complexType';
    const TAG_DEFINITIONS = 'definitions';
    const TAG_DOCUMENTATION = 'documentation';
    const TAG_ELEMENT = 'element';
    const TAG_ENUMERATION = 'enumeration';
    const TAG_EXTENSION = 'extension';
    const TAG_FIELD = 'field';
    const TAG_GROUP = 'group';
    const TAG_HEADER = 'header';
    const TAG_IMPORT = 'import';
    const TAG_INCLUDE = 'include';
    const TAG_INPUT = 'input';
    const TAG_KEY = 'key';
    const TAG_KEYREF = 'keyref';
    const TAG_LIST = 'list';
    const TAG_MEMBER_TYPES = 'memberTypes';
    const TAG_MESSAGE = 'message';
    const TAG_NOTATION = 'notation';
    const TAG_OPERATION = 'operation';
    const TAG_OUTPUT = 'output';
    const TAG_PART = 'part';
    const TAG_PORT = 'port';
    const TAG_PORT_TYPE = 'portType';
    const TAG_REDEFINE = 'redefine';
    const TAG_RESTRICTION = 'restriction';
    const TAG_SELECTOR = 'selector';
    const TAG_SEQUENCE = 'sequence';
    const TAG_SCHEMA = 'schema';
    const TAG_SIMPLE_CONTENT = 'simpleContent';
    const TAG_SIMPLE_TYPE = 'simpleType';
    const TAG_TYPES = 'types';
    const TAG_UNION = 'union';
    const TAG_UNIQUE = 'unique';

    const ATTRIBUTE_TARGET_NAMESPACE = 'targetNamespace';

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
