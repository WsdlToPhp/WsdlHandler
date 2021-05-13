<?php

declare(strict_types=1);

namespace WsdlToPhp\WsdlHandler\Tests;

use DOMDocument;
use PHPUnit\Framework\TestCase as PHPUnitFrameworkTestCase;
use WsdlToPhp\WsdlHandler\Schema;
use WsdlToPhp\WsdlHandler\Wsdl;

abstract class AbstractTestCase extends PHPUnitFrameworkTestCase
{
    private static array $instances = [];

    public static function wsdlImageServiceViewAvailRequestPath(): string
    {
        return self::getPath('image/ImageViewService.local.wsdl');
    }

    public static function wsdlImageServiceViewAvailRequestInstance(bool $addExternalSchemas = true): Wsdl
    {
        $wsdl = self::getWsdl(self::wsdlImageServiceViewAvailRequestPath(), $addExternalSchemas);

        if ($addExternalSchemas && 0 == count($wsdl->getExternalSchemas())) {
            $wsdl
                ->addExternalSchema(self::getSchema(self::getPath('image/availableImagesRequest.xsd')))
                ->addExternalSchema(self::getSchema(self::getPath('image/availableImagesResponse.xsd')))
                ->addExternalSchema(self::getSchema(self::getPath('image/imagesRequest.xsd')))
                ->addExternalSchema(self::getSchema(self::getPath('image/imagesResponse.xsd')))
                ->addExternalSchema(self::getSchema(self::getPath('image/imageViewCommon.xsd')))
            ;
        }

        return $wsdl;
    }

    public static function wsdlEbayPath(): string
    {
        return self::getPath('ebaySvc.wsdl');
    }

    public static function wsdlEbayInstance(): Wsdl
    {
        return self::getWsdl(self::wsdlEbayPath());
    }

    public static function wsdlOrderContractPath(): string
    {
        return self::getPath('OrderContract.wsdl');
    }

    public static function wsdlOrderContractInstance(): Wsdl
    {
        return self::getWsdl(self::wsdlOrderContractPath());
    }

    public static function wsdlOdigeoPath(): string
    {
        return self::getPath('odigeo.wsdl');
    }

    public static function wsdlOdigeoInstance(): Wsdl
    {
        return self::getWsdl(self::wsdlOdigeoPath());
    }

    public static function wsdlActonPath(): string
    {
        return self::getPath('ActonService2.local.wsdl');
    }

    public static function wsdlActonInstance(bool $addExternalSchemas = true): Wsdl
    {
        $wsdl = self::getWsdl(self::wsdlActonPath(), $addExternalSchemas);

        if ($addExternalSchemas && 0 == count($wsdl->getExternalSchemas())) {
            $wsdl->addExternalSchema(self::getSchema(self::getPath('xmlmime.xml')));
        }

        return $wsdl;
    }

    public static function wsdlPartnerPath(): string
    {
        return self::getPath('partner/PartnerService.local.wsdl');
    }

    public static function wsdlPartnerInstance(bool $addExternalSchemas = true): Wsdl
    {
        $wsdl = self::getWsdl(self::wsdlPartnerPath(), $addExternalSchemas);

        if ($addExternalSchemas && 0 == count($wsdl->getExternalSchemas())) {
            for ($i = 0; $i < 19; ++$i) {
                $wsdl->addExternalSchema(self::getSchema(self::getPath(sprintf('partner/PartnerService.%s.xsd', $i))));
            }
        }

        return $wsdl;
    }

    public static function schemaNumericEnumerationPath(): string
    {
        return self::getPath('numeric_enumeration.xml');
    }

    public static function schemaNumericEnumerationInstance(): Schema
    {
        return self::getSchema(self::schemaNumericEnumerationPath());
    }

    public static function wsdlDeliveryServicePath(): string
    {
        return self::getPath('DeliveryService.wsdl');
    }

    public static function wsdlDeliveryServiceInstance(): Wsdl
    {
        return self::getWsdl(self::wsdlDeliveryServicePath());
    }

    public static function wsdlWhlPath(): string
    {
        return self::getPath('whl.wsdl');
    }

    public static function wsdlWhlInstance(): Wsdl
    {
        return self::getWsdl(self::wsdlWhlPath());
    }

    public static function wsdlBingPath(): string
    {
        return self::getPath('bingsearch.wsdl');
    }

    public static function wsdlBingInstance(): Wsdl
    {
        return self::getWsdl(self::wsdlBingPath());
    }

    public static function wsdlVehicleSelectionServicePath(): string
    {
        return self::getPath('VehicleSelectionService/VehicleSelectionService.wsdl');
    }

    public static function schemaVehicleSelectionServiceSchema1Path(): string
    {
        return self::getPath('VehicleSelectionService/VehicleSelectionService_schema1.xsd');
    }

    public static function schemaVehicleSelectionServiceSchema1Instance(): Schema
    {
        return self::getSchema(self::schemaVehicleSelectionServiceSchema1Path());
    }

    public static function schemaVehicleSelectionServiceSchema2Path(): string
    {
        return self::getPath('VehicleSelectionService/VehicleSelectionService_schema2.xsd');
    }

    public static function schemaVehicleSelectionServiceSchema2Instance(): Schema
    {
        return self::getSchema(self::schemaVehicleSelectionServiceSchema2Path());
    }

    public static function wsdlVehicleSelectionServiceInstance(bool $addExternalSchemas = true): Wsdl
    {
        $wsdl = self::getWsdl(self::wsdlVehicleSelectionServicePath(), $addExternalSchemas);

        if ($addExternalSchemas && 0 == count($wsdl->getExternalSchemas())) {
            $wsdl
                ->addExternalSchema(self::schemaVehicleSelectionServiceSchema1Instance())
                ->addExternalSchema(self::schemaVehicleSelectionServiceSchema2Instance())
            ;
        }

        return $wsdl;
    }

    public static function schemaEwsMessagesPath(): string
    {
        return self::getPath('ews/messages.xsd');
    }

    public static function schemaEwsMessagesInstance(): Schema
    {
        return self::getSchema(self::schemaEwsMessagesPath());
    }

    public static function schemaEwsTypesPath(): string
    {
        return self::getPath('ews/types.xsd');
    }

    public static function schemaEwsTypesInstance(): Schema
    {
        return self::getSchema(self::schemaEwsTypesPath());
    }

    public static function wsdlUnitTestPath(): string
    {
        return self::getPath('unit_tests.wsdl');
    }

    public static function wsdlUnitTestInstance(): Wsdl
    {
        return self::getWsdl(self::wsdlUnitTestPath());
    }

    public static function getWsdl(string $wsdlPath, bool $addExternalSchemas = true): Wsdl
    {
        $wsdlKey = sprintf('%s_%s', $wsdlPath, ((int) $addExternalSchemas));
        if (!array_key_exists($wsdlKey, self::$instances)) {
            $doc = new DOMDocument('1.0', 'utf-8');
            $doc->load($wsdlPath);
            self::$instances[$wsdlKey] = new Wsdl($doc);
        }

        return self::$instances[$wsdlKey];
    }

    public static function getSchema(string $schemaPath): Schema
    {
        if (!array_key_exists($schemaPath, self::$instances)) {
            $doc = new DOMDocument('1.0', 'utf-8');
            $doc->load($schemaPath);
            self::$instances[$schemaPath] = new Schema($doc);
        }

        return self::$instances[$schemaPath];
    }

    public static function getPath(string $name): string
    {
        return sprintf('%s/%s/%s', __DIR__, 'resources', $name);
    }
}
