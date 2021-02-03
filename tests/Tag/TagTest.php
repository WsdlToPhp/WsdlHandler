<?php

declare(strict_types=1);

namespace Tag;

use WsdlToPhp\WsdlHandler\AbstractDocument;
use WsdlToPhp\WsdlHandler\Tag\Tag;
use WsdlToPhp\WsdlHandler\Tag\TagRestriction;
use WsdlToPhp\WsdlHandler\Tests\AbstractTestCase;

/**
 * @internal
 * @coversDefaultClass
 */
final class TagTest extends AbstractTestCase
{
    public function testGetFirstRestrictionChildMustReturnTheRestrictionTag()
    {
        /** @var Tag $simpleType */
        $simpleType = self::wsdlBingInstance()->getElementByNameAndAttributes(AbstractDocument::TAG_SIMPLE_TYPE, [
            'name' => 'SearchOption',
        ]);

        $this->assertInstanceOf(TagRestriction::class, $simpleType->getFirstRestrictionChild());
    }

    public function testHasRestrictionChildMustReturnTrue()
    {
        /** @var Tag $simpleType */
        $simpleType = self::wsdlBingInstance()->getElementByNameAndAttributes(AbstractDocument::TAG_SIMPLE_TYPE, [
            'name' => 'SearchOption',
        ]);

        $this->assertTrue($simpleType->hasRestrictionChild());
    }

    public function testIsTheParentMustReturnFalse()
    {
        /** @var Tag $simpleType */
        $simpleType = self::wsdlBingInstance()->getElementByNameAndAttributes(AbstractDocument::TAG_SIMPLE_TYPE, [
            'name' => 'SearchOption',
        ]);

        $this->assertFalse($simpleType->isTheParent($simpleType));
    }

    public function testIsTheParentMustReturnTrue()
    {
        /** @var Tag $simpleType */
        $simpleType = self::wsdlBingInstance()->getElementByNameAndAttributes(AbstractDocument::TAG_SIMPLE_TYPE, [
            'name' => 'SearchOption',
        ]);

        $this->assertTrue($simpleType->getFirstRestrictionChild()->isTheParent($simpleType));
    }

    public function testHasAttributeNameReturnTrue()
    {
        /** @var Tag $simpleType */
        $simpleType = self::wsdlBingInstance()->getElementByNameAndAttributes(AbstractDocument::TAG_SIMPLE_TYPE, [
            'name' => 'SearchOption',
        ]);

        $this->assertTrue($simpleType->hasAttributeName());
    }

    public function testHasAttributeNameReturnFalse()
    {
        /** @var Tag $simpleType */
        $simpleType = self::wsdlBingInstance()->getElementByNameAndAttributes(AbstractDocument::TAG_SIMPLE_TYPE, [
            'name' => 'SearchOption',
        ]);

        $this->assertFalse($simpleType->getFirstRestrictionChild()->hasAttributeName());
    }

    public function testHasAttributeRefReturnFalse()
    {
        /** @var Tag $simpleType */
        $simpleType = self::wsdlBingInstance()->getElementByNameAndAttributes(AbstractDocument::TAG_SIMPLE_TYPE, [
            'name' => 'SearchOption',
        ]);

        $this->assertFalse($simpleType->hasAttributeRef());
    }

    public function testHasAttributeValueReturnFalse()
    {
        /** @var Tag $simpleType */
        $simpleType = self::wsdlBingInstance()->getElementByNameAndAttributes(AbstractDocument::TAG_SIMPLE_TYPE, [
            'name' => 'SearchOption',
        ]);

        $this->assertFalse($simpleType->hasAttributeValue());
    }
}
