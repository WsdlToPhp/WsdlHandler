<?php

declare(strict_types=1);

namespace WsdlToPhp\WsdlHandler\Tests\Tag;

use WsdlToPhp\WsdlHandler\AbstractDocument;
use WsdlToPhp\WsdlHandler\Tag\TagMessage;
use WsdlToPhp\WsdlHandler\Tag\TagPart;
use WsdlToPhp\WsdlHandler\Tests\AbstractTestCase;

/**
 * @internal
 * @coversDefaultClass
 */
final class TagMessageTest extends AbstractTestCase
{
    public function testGetPart()
    {
        $wsdl = self::wsdlEbayInstance();

        $messages = $wsdl->getElementsByName(AbstractDocument::TAG_MESSAGE);

        $this->assertContainsOnlyInstancesOf(TagMessage::class, $messages);
        $this->assertInstanceOf(TagPart::class, $messages[0]->getPart('RequesterCredentials'));
    }
}
