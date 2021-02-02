<?php

declare(strict_types=1);

namespace WsdlToPhp\WsdlHandler\Tests\Tag;

use WsdlToPhp\WsdlHandler\AbstractDocument;
use WsdlToPhp\WsdlHandler\Tag\TagEnumeration;
use WsdlToPhp\WsdlHandler\Tag\TagRestriction;
use WsdlToPhp\WsdlHandler\Tests\AbstractTestCase;

/**
 * @internal
 * @coversDefaultClass
 */
final class TagEnumerationTest extends AbstractTestCase
{
    public function testGetValueMustReturnTheValue()
    {
        $schema = self::schemaNumericEnumerationInstance();
        $enumerations = $schema->getElementsByName(AbstractDocument::TAG_ENUMERATION);

        /**
         * @var int            $index
         * @var TagEnumeration $enumeration
         */
        foreach ($enumerations as $index => $enumeration) {
            $this->assertSame(sprintf('0%s', $index + 1), $enumeration->getValue());
        }
    }

    public function testGetRestrictionParentTypeMustReturnToken()
    {
        $schema = self::schemaNumericEnumerationInstance();
        $enumerations = $schema->getElementsByName(AbstractDocument::TAG_ENUMERATION);

        /** @var TagEnumeration $enumeration */
        foreach ($enumerations as $enumeration) {
            $this->assertSame('token', $enumeration->getRestrictionParentType());
        }
    }

    public function testGetRestrictionParentMustReturnTheRestrictionTag()
    {
        $schema = self::schemaNumericEnumerationInstance();
        $enumerations = $schema->getElementsByName(AbstractDocument::TAG_ENUMERATION);

        /** @var TagEnumeration $enumeration */
        foreach ($enumerations as $enumeration) {
            $this->assertInstanceOf(TagRestriction::class, $enumeration->getRestrictionParent());
        }
    }

    public function testHasAttributeValueMustReturnTrue()
    {
        $schema = self::schemaNumericEnumerationInstance();
        $enumerations = $schema->getElementsByName(AbstractDocument::TAG_ENUMERATION);

        /** @var TagEnumeration $enumeration */
        foreach ($enumerations as $enumeration) {
            $this->assertTrue($enumeration->hasAttributeValue());
        }
    }
}
