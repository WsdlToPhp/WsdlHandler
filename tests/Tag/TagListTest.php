<?php

declare(strict_types=1);

namespace WsdlToPhp\WsdlHandler\Tests\Tag;

use WsdlToPhp\WsdlHandler\AbstractDocument;
use WsdlToPhp\WsdlHandler\Tag\TagList;
use WsdlToPhp\WsdlHandler\Tests\AbstractTestCase;

/**
 * @internal
 * @coversDefaultClass
 */
final class TagListTest extends AbstractTestCase
{
    public function testGetItemTypeMustReturnIntForExistingItemTypeAttribute()
    {
        $wsdl = self::wsdlOdigeoInstance();

        $lists = $wsdl->getElementsByName(AbstractDocument::TAG_LIST);

        $this->assertCount(4, $lists);
        $this->assertContainsOnlyInstancesOf(TagList::class, $lists);

        /** @var TagList $list */
        foreach ($lists as $list) {
            $this->assertSame('int', $list->getItemType());
        }
    }

    public function testGetItemTypeMustReturnCorrespondingValueFromRestrictionChildOrItemType()
    {
        $wsdl = self::schemaEwsTypesInstance();
        $lists = $wsdl->getElementsByName(AbstractDocument::TAG_LIST);
        $types = [
            'string',
            'string',
            'string',
            'string',
            'string',
            'DayOfWeekType',
            'string',
            'string',
            'string',
            'string',
            'string',
            'string',
            'string',
            'string',
            'string',
        ];
        $itemTypes = [
            '',
            '',
            '',
            '',
            '',
            'DayOfWeekType',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
        ];

        $this->assertCount(15, $lists);
        $this->assertContainsOnlyInstancesOf(TagList::class, $lists);

        /** @var TagList $list */
        foreach ($lists as $index => $list) {
            $this->assertSame($itemTypes[$index], $list->getAttributeItemType());
            $this->assertSame($types[$index], $list->getItemType());
        }
    }
}
