<?php

declare(strict_types=1);

namespace WsdlToPhp\WsdlHandler\Tag;

use WsdlToPhp\WsdlHandler\AbstractDocument;

class TagAttributeGroup extends Tag
{
    public function getReferencingElements(): array
    {
        $elements = [];
        $attributeGroups = $this->getDomDocumentHandler()->getElementsByNameAndAttributes(AbstractDocument::TAG_ATTRIBUTE_GROUP, [
            'ref' => sprintf('*:%s', $this->getAttributeName()),
        ]);
        /*
         * In case of a referencing element that use this attributeGroup that is not namespaced,
         * use the non namespaced value
         */
        if (empty($attributeGroups)) {
            $attributeGroups = $this->getDomDocumentHandler()->getElementsByNameAndAttributes(AbstractDocument::TAG_ATTRIBUTE_GROUP, [
                'ref' => sprintf('*%s', $this->getAttributeName()),
            ]);
        }

        /** @var AbstractTag $attributeGroup */
        foreach ($attributeGroups as $attributeGroup) {
            $parent = $attributeGroup->getSuitableParent();
            /*
             * In this case, this means the attribute is included in another attribute group,
             * this means we must climb to its parent recursively until we find the elements referencing the top attributeGroup tag
             */
            if ($parent instanceof TagAttributeGroup) {
                $elements = array_merge($elements, $parent->getReferencingElements());
            } elseif ($parent instanceof AbstractTag) {
                $elements[] = $parent;
            }
        }

        return $elements;
    }
}
