<?php

declare(strict_types=1);

namespace WsdlToPhp\WsdlHandler\Tests\Tag;

use WsdlToPhp\WsdlHandler\AbstractDocument;
use WsdlToPhp\WsdlHandler\Tag\TagHeader;
use WsdlToPhp\WsdlHandler\Tag\TagInput;
use WsdlToPhp\WsdlHandler\Tag\TagMessage;
use WsdlToPhp\WsdlHandler\Tag\TagOperation;
use WsdlToPhp\WsdlHandler\Tag\TagPart;
use WsdlToPhp\WsdlHandler\Tests\AbstractTestCase;

/**
 * @internal
 * @coversDefaultClass
 */
final class TagHeaderTest extends AbstractTestCase
{
    public function testHeaders()
    {
        $wsdl = self::wsdlEbayInstance();

        $headers = $wsdl->getElementsByName(AbstractDocument::TAG_HEADER);

        foreach ($headers as $header) {
            if ($header->getParentInput() instanceof TagInput) {
                $this->assertInstanceOf(TagOperation::class, $header->getParentOperation());
                $this->assertInstanceOf(TagInput::class, $header->getParentInput());
                $this->assertSame('RequesterCredentials', $header->getAttributePart());
                $this->assertSame('RequesterCredentials', $header->getAttributeMessage());
                $this->assertSame('', $header->getAttributeNamespace());
            }
        }
    }

    public function testGetMessage()
    {
        $wsdl = self::wsdlEbayInstance();

        $header = $wsdl->getElementByName(AbstractDocument::TAG_HEADER);

        $this->assertInstanceOf(TagMessage::class, $header->getMessage());
    }

    public function testGetPartMustReturnPartTag()
    {
        $wsdl = self::wsdlEbayInstance();

        $header = $wsdl->getElementByName(AbstractDocument::TAG_HEADER);

        $this->assertInstanceOf(TagPart::class, $header->getPartTag());
    }

    public function testGetPartFinalTypeMustReturnFinalType()
    {
        $wsdl = self::wsdlEbayInstance();

        $header = $wsdl->getElementByName(AbstractDocument::TAG_HEADER);

        $this->assertSame('CustomSecurityHeaderType', $header->getPartTag()->getFinalType());
    }

    public function testGetPartFinalNamespaceMustReturnFinalNamespace()
    {
        $wsdl = self::wsdlEbayInstance();

        $header = $wsdl->getElementByName(AbstractDocument::TAG_HEADER);

        $this->assertSame('ns', $header->getPartTag()->getFinalNamespace());
    }

    public function testGetHeaderNamespaceMustReturnNamespace()
    {
        $wsdl = self::wsdlEbayInstance();

        $header = $wsdl->getElementByName(AbstractDocument::TAG_HEADER);

        $this->assertSame('urn:ebay:apis:eBLBaseComponents', $header->getHeaderNamespace());
    }

    public function testGetHeaderNamespaceMustReturnNamespaceFromSchemaContainingElementMatchingPart()
    {
        $wsdl = self::wsdlUnitTestInstance();

        $header = $wsdl->getElementByName(AbstractDocument::TAG_HEADER);

        $this->assertSame('http://schemas.com/GetResult', $header->getHeaderNamespace());
    }

    public function testGetAttributeRequiredMustReturnTrueOrFalse()
    {
        $wsdl = self::wsdlActonInstance();

        $binding = $wsdl->getElementByNameAndAttributes(AbstractDocument::TAG_BINDING, [
            'name' => 'SoapBinding',
            'type' => 'tns:SOAP',
        ]);

        $operation = $binding->getChildByNameAndAttributes(AbstractDocument::TAG_OPERATION, [
            'name' => 'list',
        ]);

        /** @var TagHeader $sessionHeader */
        $sessionHeader = $operation->getChildByNameAndAttributes(AbstractDocument::TAG_HEADER, [
            'part' => 'SessionHeader',
        ]);

        /** @var TagHeader $clusterHeader */
        $clusterHeader = $operation->getChildByNameAndAttributes(AbstractDocument::TAG_HEADER, [
            'part' => 'ClusterHeader',
        ]);

        $this->assertFalse($sessionHeader->getAttributeRequired());
        $this->assertTrue($clusterHeader->getAttributeRequired());
    }

    public function testGetHeaderTypeMustReturnHeaderType()
    {
        $wsdl = self::wsdlActonInstance();

        $binding = $wsdl->getElementByNameAndAttributes(AbstractDocument::TAG_BINDING, [
            'name' => 'SoapBinding',
            'type' => 'tns:SOAP',
        ]);

        $operation = $binding->getChildByNameAndAttributes(AbstractDocument::TAG_OPERATION, [
            'name' => 'list',
        ]);

        /** @var TagHeader $sessionHeader */
        $sessionHeader = $operation->getChildByNameAndAttributes(AbstractDocument::TAG_HEADER, [
            'part' => 'SessionHeader',
        ]);

        /** @var TagHeader $clusterHeader */
        $clusterHeader = $operation->getChildByNameAndAttributes(AbstractDocument::TAG_HEADER, [
            'part' => 'ClusterHeader',
        ]);

        $this->assertSame('SessionHeader', $sessionHeader->getHeaderType());
        $this->assertSame('ClusterHeader', $clusterHeader->getHeaderType());
    }

    public function testGetHeaderNameMustReturnHeaderName()
    {
        $wsdl = self::wsdlActonInstance();

        $binding = $wsdl->getElementByNameAndAttributes(AbstractDocument::TAG_BINDING, [
            'name' => 'SoapBinding',
            'type' => 'tns:SOAP',
        ]);

        $operation = $binding->getChildByNameAndAttributes(AbstractDocument::TAG_OPERATION, [
            'name' => 'list',
        ]);

        /** @var TagHeader $sessionHeader */
        $sessionHeader = $operation->getChildByNameAndAttributes(AbstractDocument::TAG_HEADER, [
            'part' => 'SessionHeader',
        ]);

        /** @var TagHeader $clusterHeader */
        $clusterHeader = $operation->getChildByNameAndAttributes(AbstractDocument::TAG_HEADER, [
            'part' => 'ClusterHeader',
        ]);

        $this->assertSame('SessionHeader', $sessionHeader->getHeaderName());
        $this->assertSame('ClusterHeader', $clusterHeader->getHeaderName());
    }

    public function testGetHeaderRequiredMustReturnRequiredOrOptional()
    {
        $wsdl = self::wsdlActonInstance();

        $binding = $wsdl->getElementByNameAndAttributes(AbstractDocument::TAG_BINDING, [
            'name' => 'SoapBinding',
            'type' => 'tns:SOAP',
        ]);

        $operation = $binding->getChildByNameAndAttributes(AbstractDocument::TAG_OPERATION, [
            'name' => 'list',
        ]);

        /** @var TagHeader $sessionHeader */
        $sessionHeader = $operation->getChildByNameAndAttributes(AbstractDocument::TAG_HEADER, [
            'part' => 'SessionHeader',
        ]);

        /** @var TagHeader $clusterHeader */
        $clusterHeader = $operation->getChildByNameAndAttributes(AbstractDocument::TAG_HEADER, [
            'part' => 'ClusterHeader',
        ]);

        $this->assertSame(TagHeader::OPTIONAL_HEADER, $sessionHeader->getHeaderRequired());
        $this->assertSame(TagHeader::REQUIRED_HEADER, $clusterHeader->getHeaderRequired());
    }

    public function testGetAttributeMessageNamespaceMustReturnMessageNamespace()
    {
        $wsdl = self::wsdlActonInstance();

        $binding = $wsdl->getElementByNameAndAttributes(AbstractDocument::TAG_BINDING, [
            'name' => 'SoapBinding',
            'type' => 'tns:SOAP',
        ]);

        $operation = $binding->getChildByNameAndAttributes(AbstractDocument::TAG_OPERATION, [
            'name' => 'list',
        ]);

        /** @var TagHeader $sessionHeader */
        $sessionHeader = $operation->getChildByNameAndAttributes(AbstractDocument::TAG_HEADER, [
            'part' => 'SessionHeader',
        ]);

        /** @var TagHeader $clusterHeader */
        $clusterHeader = $operation->getChildByNameAndAttributes(AbstractDocument::TAG_HEADER, [
            'part' => 'ClusterHeader',
        ]);

        $this->assertSame('tns', $sessionHeader->getAttributeMessageNamespace());
        $this->assertSame('tns', $clusterHeader->getAttributeMessageNamespace());
    }

    public function testGetPartsMustReturnPartTags()
    {
        $wsdl = self::wsdlActonInstance();

        $binding = $wsdl->getElementByNameAndAttributes(AbstractDocument::TAG_BINDING, [
            'name' => 'SoapBinding',
            'type' => 'tns:SOAP',
        ]);

        $operation = $binding->getChildByNameAndAttributes(AbstractDocument::TAG_OPERATION, [
            'name' => 'list',
        ]);

        /** @var TagHeader $sessionHeader */
        $sessionHeader = $operation->getChildByNameAndAttributes(AbstractDocument::TAG_HEADER, [
            'part' => 'SessionHeader',
        ]);

        $this->assertCount(3, $parts = $sessionHeader->getParts());
        $this->assertContainsOnlyInstancesOf(TagPart::class, $parts);
    }
}
