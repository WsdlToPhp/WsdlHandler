<?php

declare(strict_types=1);

namespace WsdlToPhp\WsdlHandler\Tests\Tag;

use WsdlToPhp\WsdlHandler\AbstractDocument;
use WsdlToPhp\WsdlHandler\Tag\AbstractTag;
use WsdlToPhp\WsdlHandler\Tag\TagDocumentation;
use WsdlToPhp\WsdlHandler\Tag\TagEnumeration;
use WsdlToPhp\WsdlHandler\Tests\AbstractTestCase;

/**
 * @internal
 * @coversDefaultClass
 */
final class TagDocumentationTest extends AbstractTestCase
{
    public function testGetSuitableParentMustReturn()
    {
        $wsdl = self::wsdlImageServiceViewAvailRequestInstance();
        $documentations = $wsdl->getElementsByName(AbstractDocument::TAG_DOCUMENTATION, true);

        $this->assertCount(14, $documentations);
        $this->assertContainsOnlyInstancesOf(TagDocumentation::class, $documentations);

        $names = [
            3 => 'availRequest',
            6 => 'imgRequest',
            8 => 'ImagesType',
            10 => 'DocumentType',
            11 => 'ProType',
            12 => 'SearchCriteriaType',
            13 => 'SearchItemType',
        ];

        $assertCount = 0;

        /** @var TagDocumentation $documentation */
        foreach ($documentations as $index => $documentation) {
            $parent = $documentation->getSuitableParent();
            if ($parent instanceof AbstractTag) {
                $this->assertSame($names[$index], $parent->getAttributeName());
                ++$assertCount;
            }
        }

        $this->assertCount($assertCount, $names, sprintf('Unable to find suitable parent named %s', implode(', ', $names)));
    }

    public function testGetSuitableParentAsEnumeration()
    {
        $wsdl = self::wsdlEbayInstance();
        $enumeration = $wsdl->getElementByNameAndAttributes(AbstractDocument::TAG_ENUMERATION, [
            'value' => 'Success',
        ]);

        $this->assertSame('Success', $enumeration->getValue());

        /** @var TagDocumentation $documentation */
        $documentation = $enumeration->getChildByNameAndAttributes(AbstractDocument::TAG_DOCUMENTATION, []);

        $this->assertSame('(out) Request processing succeeded', $documentation->getValue());
        $this->assertSame($documentation->getValue(), $documentation->getContent());
        $this->assertInstanceOf(TagDocumentation::class, $documentation);
        $this->assertInstanceOf(TagEnumeration::class, $documentation->getSuitableParent());
        $this->assertSame($enumeration->getValue(), $documentation->getSuitableParent()->getValue());
    }
}
