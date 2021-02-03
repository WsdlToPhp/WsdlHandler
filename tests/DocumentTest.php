<?php

declare(strict_types=1);

namespace WsdlToPhp\WsdlHandler\Tests;

use DOMDocument;
use WsdlToPhp\WsdlHandler\Tag\TagComplexType;
use WsdlToPhp\WsdlHandler\Tag\TagDefinitions;
use WsdlToPhp\WsdlHandler\Wsdl;

/**
 * @internal
 * @coversDefaultClass
 */
final class DocumentTest extends AbstractTestCase
{
    public function testGetElementByNameFromWsdl()
    {
        ($dom = new DOMDocument())->load(self::wsdlBingPath());
        $bing = new Document($dom);

        $this->assertInstanceOf(TagComplexType::class, $bing->getElementByName(Wsdl::TAG_COMPLEX_TYPE));
    }

    public function testGetRootElement()
    {
        ($dom = new DOMDocument())->load(self::wsdlBingPath());
        $bing = new Document($dom);

        $this->assertSame('definitions', $bing->getRootElement()->getName());
        $this->assertInstanceOf(TagDefinitions::class, $bing->getRootElement());
    }

    public function testGetNamespaceUri()
    {
        ($dom = new DOMDocument())->load(self::wsdlBingPath());
        $bing = new Document($dom);

        $this->assertSame('http://www.w3.org/2001/XMLSchema-instance', $bing->getNamespaceUri('xsi'));
        $this->assertSame('http://schemas.xmlsoap.org/wsdl/soap/', $bing->getNamespaceUri('soap'));
        $this->assertSame('http://schemas.xmlsoap.org/wsdl/', $bing->getNamespaceUri('wsdl'));
        $this->assertSame('http://schemas.xmlsoap.org/ws/2004/08/addressing', $bing->getNamespaceUri('wsa'));
        $this->assertSame('http://schemas.microsoft.com/LiveSearch/2008/03/Search', $bing->getNamespaceUri('tns'));
        $this->assertSame('http://www.w3.org/2001/XMLSchema', $bing->getNamespaceUri('xsd'));
    }
}
