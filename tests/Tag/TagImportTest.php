<?php

declare(strict_types=1);

namespace WsdlToPhp\WsdlHandler\Tests\Tag;

use WsdlToPhp\WsdlHandler\AbstractDocument;
use WsdlToPhp\WsdlHandler\Tag\TagImport;
use WsdlToPhp\WsdlHandler\Tests\AbstractTestCase;

/**
 * @internal
 * @coversDefaultClass
 */
final class TagImportTest extends AbstractTestCase
{
    public function testGetLocationAttributeValueMustReturnTheSchemaLocation()
    {
        $wsdl = self::wsdlPartnerInstance();

        $imports = $wsdl->getElementsByName(AbstractDocument::TAG_IMPORT);

        $this->assertCount(19, $imports);
        $this->assertContainsOnlyInstancesOf(TagImport::class, $imports);

        /**
         * @var int       $index
         * @var TagImport $import
         */
        foreach ($imports as $index => $import) {
            $this->assertSame(sprintf('PartnerService.%d.xsd', $index), $import->getLocationAttributeValue());
        }
    }
}
