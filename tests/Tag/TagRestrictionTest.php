<?php

declare(strict_types=1);

namespace WsdlToPhp\WsdlHandler\Tests\Tag;

use WsdlToPhp\WsdlHandler\AbstractDocument;
use WsdlToPhp\WsdlHandler\Tests\AbstractTestCase;
use WsdlToPhp\WsdlHandler\Tag\TagRestriction;

final class TagRestrictionTest extends AbstractTestCase
{
    public function testIsEnumeration()
    {
        $wsdl = self::wsdlBingInstance();
        $restrictions = $wsdl->getElementsByName(AbstractDocument::TAG_RESTRICTION);

        $this->assertCount(8, $restrictions);
        $this->assertContainsOnlyInstancesOf(TagRestriction::class, $restrictions);

        /** @var TagRestriction $restriction */
        foreach ($restrictions as $restriction) {
            $this->assertTrue($restriction->isEnumeration());
            $this->assertTrue($restriction->hasAttributeBase());
            $this->assertFalse($restriction->hasUnionParent());
        }
    }
}
