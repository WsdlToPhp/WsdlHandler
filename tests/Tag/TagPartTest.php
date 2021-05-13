<?php

declare(strict_types=1);

namespace WsdlToPhp\WsdlHandler\Tests\Tag;

use WsdlToPhp\WsdlHandler\AbstractDocument;
use WsdlToPhp\WsdlHandler\Tag\TagElement;
use WsdlToPhp\WsdlHandler\Tag\TagPart;
use WsdlToPhp\WsdlHandler\Tests\AbstractTestCase;

/**
 * @internal
 * @coversDefaultClass
 */
final class TagPartTest extends AbstractTestCase
{
    public function testGetMatchingElementMustReturnAnElement()
    {
        $instance = self::wsdlUnitTestInstance();

        /** @var TagPart $tagPart */
        $tagPart = $instance->getElementByNameAndAttributes(AbstractDocument::TAG_PART, [
            'name' => 'authentication',
        ]);

        $this->assertInstanceOf(TagPart::class, $tagPart);
        $this->assertInstanceOf(TagElement::class, $tagPart->getMatchingElement());
    }
}
