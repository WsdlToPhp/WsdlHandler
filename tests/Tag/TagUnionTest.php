<?php

declare(strict_types=1);

namespace WsdlToPhp\WsdlHandler\Tests\Tag;

use WsdlToPhp\WsdlHandler\AbstractDocument;
use WsdlToPhp\WsdlHandler\Tag\TagUnion;
use WsdlToPhp\WsdlHandler\Tests\AbstractTestCase;

/**
 * @internal
 * @coversDefaultClass
 */
final class TagUnionTest extends AbstractTestCase
{
    public function testGetAttributeMemberTypes()
    {
        $wsdl = self::wsdlOrderContractInstance();

        $unions = $wsdl->getElementsByName(AbstractDocument::TAG_UNION);

        $this->assertCount(2, $unions);
        $this->assertContainsOnlyInstancesOf(TagUnion::class, $unions);

        $ok = false;
        foreach ($unions as $union) {
            switch ($union->getSuitableParent()->getAttributeName()) {
                case 'RelationshipTypeOpenEnum':
                    $this->assertSame([
                        'RelationshipType',
                        'anyURI',
                    ], $union->getAttributeMemberTypes());
                    $ok |= true;

                    break;

                case 'FaultCodesOpenEnumType':
                    $this->assertSame([
                        'FaultCodesType',
                        'QName',
                    ], $union->getAttributeMemberTypes());
                    $ok |= true;

                    break;
            }
        }
        $this->assertTrue((bool) $ok);
    }

    public function testHasMemberTypesAsChildrenMustReturnFalse()
    {
        $wsdl = self::wsdlOrderContractInstance();
        $unions = $wsdl->getElementsByName(AbstractDocument::TAG_UNION);

        $this->assertCount(2, $unions);
        $this->assertContainsOnlyInstancesOf(TagUnion::class, $unions);

        $tests = 0;

        /** @var TagUnion $union */
        foreach ($unions as $union) {
            switch ($union->getSuitableParent()->getAttributeName()) {
                case 'RelationshipTypeOpenEnum':
                    $this->assertFalse($union->hasMemberTypesAsChildren());
                    ++$tests;

                    break;

                case 'FaultCodesOpenEnumType':
                    $this->assertFalse($union->hasMemberTypesAsChildren());
                    ++$tests;

                    break;
            }
        }

        $this->assertSame(2, $tests);
    }

    public function testHasMemberTypesAsChildrenMustReturnTrue()
    {
        $schema = self::schemaEwsTypesInstance();
        $unions = $schema->getElementsByName(AbstractDocument::TAG_UNION);

        $this->assertCount(2, $unions);
        $this->assertContainsOnlyInstancesOf(TagUnion::class, $unions);

        $tests = 0;

        /** @var TagUnion $union */
        foreach ($unions as $union) {
            switch ($union->getSuitableParent()->getAttributeName()) {
                case 'ReminderMinutesBeforeStartType':
                    $this->assertTrue($union->hasMemberTypesAsChildren());
                    ++$tests;

                    break;

                case 'PropertyTagType':
                    $this->assertTrue($union->hasMemberTypesAsChildren());
                    ++$tests;

                    break;
            }
        }

        $this->assertSame(2, $tests);
    }

    public function testGetMemberTypesChildrenMustReturnTheChildren()
    {
        $schema = self::schemaEwsTypesInstance();
        $unions = $schema->getElementsByName(AbstractDocument::TAG_UNION);

        $this->assertCount(2, $unions);
        $this->assertContainsOnlyInstancesOf(TagUnion::class, $unions);

        $tests = 0;

        /** @var TagUnion $union */
        foreach ($unions as $union) {
            switch ($union->getSuitableParent()->getAttributeName()) {
                case 'ReminderMinutesBeforeStartType':
                    $this->assertCount(2, $union->getMemberTypesChildren());
                    ++$tests;

                    break;

                case 'PropertyTagType':
                    $this->assertCount(1, $union->getMemberTypesChildren());
                    ++$tests;

                    break;
            }
        }

        $this->assertSame(2, $tests);
    }
}
