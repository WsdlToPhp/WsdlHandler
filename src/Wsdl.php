<?php

declare(strict_types=1);

namespace WsdlToPhp\WsdlHandler;

use DOMNode;
use DOMNodeList;
use WsdlToPhp\WsdlHandler\Tag\AbstractTag;

class Wsdl extends AbstractDocument
{
    protected array $externalSchemas = [];

    public function addExternalSchema(Schema $schema): Wsdl
    {
        $this->externalSchemas[] = $schema;

        return $this;
    }

    public function getExternalSchemas(): array
    {
        return $this->externalSchemas;
    }

    public function getElementByName(string $name, bool $includeExternals = false): ?AbstractTag
    {
        return $this->useParentMethodAndExternals(__FUNCTION__, [
            $name,
        ], $includeExternals, true);
    }

    public function getElementByNameAndAttributes(string $name, array $attributes, bool $includeExternals = false): ?AbstractTag
    {
        return $this->useParentMethodAndExternals(__FUNCTION__, [
            $name,
            $attributes,
        ], $includeExternals, true);
    }

    public function getElementsByName(string $name, bool $includeExternals = false): array
    {
        return $this->useParentMethodAndExternals(__FUNCTION__, [
            $name,
        ], $includeExternals);
    }

    public function getElementsByNameAndAttributes(string $name, array $attributes, ?DOMNode $node = null, bool $includeExternals = false): array
    {
        if ($includeExternals) {
            $elements = $this->useParentMethodAndExternals(__FUNCTION__, [
                $name,
                $attributes,
                $node,
            ]);
            /** @var Schema $externalSchema */
            foreach ($this->getExternalSchemas() as $index => $externalSchema) {
                $nodes = $externalSchema->searchTagsByXpath($name, $attributes, $node);
                if (!empty($nodes)) {
                    $elements = array_merge($elements, $this->getElementsHandlers($nodes));
                    break;
                }
            }
        } else {
            $elements = $this->useParentMethodAndExternals(__FUNCTION__, [
                $name,
                $attributes,
                $node,
            ], $includeExternals);
        }

        return $elements;
    }

    /**
     * Handles any method that exist within the parent class,
     * in addition it handles the case when we want to use the external schemas to search in
     * @param string $method
     * @param array $parameters
     * @param bool $includeExternals
     * @param bool $returnOne
     * @return mixed
     */
    protected function useParentMethodAndExternals(string $method, array $parameters, bool $includeExternals = false, bool $returnOne = false)
    {
        $result = call_user_func_array([
            $this,
            sprintf('parent::%s', $method),
        ], $parameters);

        if ($includeExternals && (!$returnOne || empty($result))) {
            $result = $this->useExternalSchemas($method, $parameters, $result, $returnOne);
        }

        return $result;
    }

    protected function useExternalSchemas(string $method, array $parameters, $parentResult, bool $returnOne = false)
    {
        $result = $parentResult;

        foreach ($this->getExternalSchemas() as $externalSchema) {
            $externalResult = call_user_func_array([
                $externalSchema,
                $method,
            ], $parameters);

            if ($returnOne && !is_null($externalResult)) {
                $result = $externalResult;
                break;
            } elseif (is_array($externalResult) && !empty($externalResult)) {
                $result = array_merge($result, $externalResult);
            }
        }

        return $result;
    }
}
