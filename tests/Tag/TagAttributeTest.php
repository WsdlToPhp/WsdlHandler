<?php

declare(strict_types=1);

namespace WsdlToPhp\WsdlHandler\Tests\Tag;

use WsdlToPhp\WsdlHandler\AbstractDocument;
use WsdlToPhp\WsdlHandler\Tag\TagAttribute;
use WsdlToPhp\WsdlHandler\Tag\TagAttributeGroup;
use WsdlToPhp\WsdlHandler\Tests\AbstractTestCase;

/**
 * @internal
 * @coversDefaultClass
 */
final class TagAttributeTest extends AbstractTestCase
{
    public function testGetSuitableParentAsAttributeGroupMustReturnAttributeGroupParent()
    {
        $schema = self::wsdlWhlInstance();

        /** @var TagAttribute $attribute */
        $attribute = $schema->getElementByNameAndAttributes(AbstractDocument::TAG_ATTRIBUTE, [
            'name' => 'ShortText',
            'type' => 'whlsoap:StringLength1to64',
            'use' => 'optional',
        ]);

        $this->assertInstanceOf(TagAttribute::class, $attribute);

        $parent = $attribute->getSuitableParent();
        $this->assertInstanceOf(TagAttributeGroup::class, $parent);
        $this->assertSame(AbstractDocument::TAG_ATTRIBUTE_GROUP, $parent->getName());
    }
}
