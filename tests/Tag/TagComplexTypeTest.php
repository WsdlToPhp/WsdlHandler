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
final class TagComplexTypeTest extends AbstractTestCase
{
    public function testGetTargetNamespaceMustReturnTheTargetNamespaceAttributeValue()
    {
        /** @var Tag $complexType */
        $complexType = self::wsdlBingInstance()->getElementByNameAndAttributes(AbstractDocument::TAG_COMPLEX_TYPE, [
            'name' => 'ArrayOfInstantAnswerResult',
        ]);

        $this->assertSame('http://schemas.microsoft.com/LiveSearch/2008/03/Search', $complexType->getTargetNamespace());
    }
}
