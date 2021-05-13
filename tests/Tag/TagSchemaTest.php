<?php

declare(strict_types=1);

namespace Tag;

use WsdlToPhp\WsdlHandler\AbstractDocument;
use WsdlToPhp\WsdlHandler\Tag\Tag;
use WsdlToPhp\WsdlHandler\Tests\AbstractTestCase;

/**
 * @internal
 * @coversDefaultClass
 */
final class TagSchemaTest extends AbstractTestCase
{
    public function testHasAttributeTargetNamespaceMustReturnTrue()
    {
        /** @var Tag $schema */
        $schema = self::wsdlBingInstance()->getElementByName(AbstractDocument::TAG_SCHEMA);

        $this->assertTrue($schema->hasAttributeTargetNamespace());
    }

    public function testGetTargetNamespaceAttributeValueMustReturnTheTargetNamespaceAttributeValue()
    {
        /** @var Tag $schema */
        $schema = self::wsdlBingInstance()->getElementByName(AbstractDocument::TAG_SCHEMA);

        $this->assertSame('http://schemas.microsoft.com/LiveSearch/2008/03/Search', $schema->getTargetNamespaceAttributeValue());
    }

    public function testGetTargetNamespaceMustReturnTheTargetNamespaceAttributeValue()
    {
        /** @var Tag $schema */
        $schema = self::wsdlBingInstance()->getElementByName(AbstractDocument::TAG_SCHEMA);

        $this->assertSame('http://schemas.microsoft.com/LiveSearch/2008/03/Search', $schema->getTargetNamespace());
    }
}
