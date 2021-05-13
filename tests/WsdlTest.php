<?php

declare(strict_types=1);

namespace WsdlToPhp\WsdlHandler\Tests;

use DOMNode;
use WsdlToPhp\WsdlHandler\AbstractDocument;
use WsdlToPhp\WsdlHandler\Tag\TagComplexContent;
use WsdlToPhp\WsdlHandler\Tag\TagComplexType;
use WsdlToPhp\WsdlHandler\Tag\TagElement;
use WsdlToPhp\WsdlHandler\Tag\TagExtension;

/**
 * @internal
 * @coversDefaultClass
 */
final class WsdlTest extends AbstractTestCase
{
    public function testGetExternalSchemasMustReturnAnEmptyArray()
    {
        $this->assertCount(0, self::wsdlBingInstance()->getExternalSchemas());
    }

    public function testGetElementByNameMustReturnTheTagComplexTypeFromTheWsdl()
    {
        $this->assertInstanceOf(TagComplexType::class, $complexType = self::wsdlBingInstance()->getElementByName(AbstractDocument::TAG_COMPLEX_TYPE));
        $this->assertSame('SearchRequest', $complexType->getAttributeValue('name'));
    }

    public function testGetElementByNameAndAttributesMustReturnTheTagComplexTypeFromTheWsdl()
    {
        $this->assertInstanceOf(TagComplexType::class, $complexType = self::wsdlBingInstance()->getElementByNameAndAttributes(AbstractDocument::TAG_COMPLEX_TYPE, [
            'name' => 'SearchRequest',
        ]));
        $this->assertSame('SearchRequest', $complexType->getAttributeValue('name'));
    }

    public function testGetElementsByNameMustReturnTheTagComplexTypesFromTheWsdl()
    {
        $this->assertCount(54, $complexTypes = self::wsdlBingInstance()->getElementsByName(AbstractDocument::TAG_COMPLEX_TYPE));
        $this->assertContainsOnlyInstancesOf(TagComplexType::class, $complexTypes);
    }

    public function testGetElementsByNameAndAttributesMustReturnTheTagElementFromTheWsdl()
    {
        $this->assertCount(144, $elements = self::wsdlBingInstance()->getElementsByNameAndAttributes(AbstractDocument::TAG_ELEMENT, [
            'minOccurs' => 0,
            'maxOccurs' => 1,
        ]));
        $this->assertContainsOnlyInstancesOf(TagElement::class, $elements);
    }

    public function testGetElementsByNameAndAttributesFromDomNodeMustReturnTheElementFromTheWsdl()
    {
        $fromNode = ($instance = self::wsdlBingInstance())->getElementByName(AbstractDocument::TAG_COMPLEX_TYPE)->getNode();

        $this->assertCount(15, $elements = $instance->getElementsByNameAndAttributes(AbstractDocument::TAG_ELEMENT, [
            'minOccurs' => 0,
            'maxOccurs' => 1,
        ], $fromNode));
        $this->assertContainsOnlyInstancesOf(TagElement::class, $elements);
    }

    public function testAddExternalSchemaMustFillTheArrayWithOneSchema()
    {
        $this->assertCount(
            1,
            self::wsdlVehicleSelectionServiceInstance(false)
                ->addExternalSchema(self::schemaVehicleSelectionServiceSchema1Instance())
                ->getExternalSchemas()
        );
    }

    public function testAddExternalSchemaMustFillTheArrayWithTheSchemas()
    {
        $this->assertCount(2, self::wsdlVehicleSelectionServiceInstance()->getExternalSchemas());
    }

    public function testGetElementByNameMustReturnNullFromTheWsdl()
    {
        $this->assertNull(self::wsdlVehicleSelectionServiceInstance()->getElementByName(AbstractDocument::TAG_COMPLEX_CONTENT, false));
    }

    public function testGetElementByNameMustReturnTheTagComplexContentFromTheExternalSchemas()
    {
        $this->assertInstanceOf(TagComplexContent::class, self::wsdlVehicleSelectionServiceInstance()->getElementByName(AbstractDocument::TAG_COMPLEX_CONTENT, true));
    }

    public function testGetElementByNameAndAttributesMustReturnNullFromTheWsdl()
    {
        $this->assertNull(self::wsdlBingInstance()->getElementByNameAndAttributes(AbstractDocument::TAG_ELEMENT, [
            'name' => 'ActualRepairCost',
        ]));
    }

    public function testGetElementByNameAndAttributesMustReturnTheTagElementFromTheExternalSchemas()
    {
        $this->assertInstanceOf(TagElement::class, $element = self::wsdlVehicleSelectionServiceInstance()->getElementByNameAndAttributes(AbstractDocument::TAG_ELEMENT, [
            'name' => 'ActualRepairCost',
        ], true));
        $this->assertSame('ActualRepairCost', $element->getAttributeValue('name'));
    }

    public function testGetElementsByNameMustReturnAnEmptyArrayFromTheWsdl()
    {
        $this->assertEmpty(self::wsdlVehicleSelectionServiceInstance()->getElementsByName(AbstractDocument::TAG_COMPLEX_CONTENT));
    }

    public function testGetElementsByNameMustReturnTheComplexContentsFromTheExternalSchemas()
    {
        $this->assertCount(18, $complexContents = self::wsdlVehicleSelectionServiceInstance()->getElementsByName(AbstractDocument::TAG_COMPLEX_CONTENT, true));
        $this->assertContainsOnlyInstancesOf(TagComplexContent::class, $complexContents);
    }

    public function testGetElementsByNameAndAttributesMustReturnAnEmptyArrayFromTheWsdl()
    {
        $this->assertEmpty(self::wsdlVehicleSelectionServiceInstance()->getElementsByNameAndAttributes(AbstractDocument::TAG_EXTENSION, [
            'base' => 'xs:string',
        ]));
    }

    public function testGetElementsByNameAndAttributesMustReturnTheExtensionsFromTheExternalSchemas()
    {
        $this->assertCount(10, $extensions = self::wsdlVehicleSelectionServiceInstance()->getElementsByNameAndAttributes(AbstractDocument::TAG_EXTENSION, [
            'base' => 'xs:string',
        ], null, true));
        $this->assertContainsOnlyInstancesOf(TagExtension::class, $extensions);
    }

    public function testGetElementsByNameAndAttributesUsingDomNodeMustReturnTheExtensionsFromTheExternalSchemas()
    {
        $element = ($instance = self::wsdlVehicleSelectionServiceInstance())->getElementByNameAndAttributes(AbstractDocument::TAG_COMPLEX_TYPE, [
            'name' => 'getHgvPlatformSubModelDataResponse',
        ], true);

        $this->assertInstanceOf(TagComplexType::class, $element);

        $fromNode = $element->getNode();

        $this->assertInstanceOf(DOMNode::class, $fromNode);

        $this->assertCount(30, $elements = $instance->getElementsByNameAndAttributes(AbstractDocument::TAG_ELEMENT, [
            'form' => 'qualified',
        ], $fromNode, true));
        $this->assertContainsOnlyInstancesOf(TagElement::class, $elements);
    }

    public function testGetElementsByNameAndAttributesMustReturnTheExtensionsFromTheLastExternalSchema()
    {
        $this->assertCount(1, $elements = self::wsdlPartnerInstance()->getElementsByNameAndAttributes(AbstractDocument::TAG_ELEMENT, [
            'name' => 'SimpleIsMemberFaultReason',
        ], null, true));
        $this->assertContainsOnlyInstancesOf(TagElement::class, $elements);
    }

    public function testGetAttributeTargetNamespaceValueMustReturnTheTargetNamespaceAttributeValue()
    {
        $this->assertSame('http://schemas.microsoft.com/LiveSearch/2008/03/Search', self::wsdlBingInstance()->getAttributeTargetNamespaceValue());
    }
}
