<?php

class Glew_Service_Model_Types_Product
{
    public function parse($productId, $productAttributes)
    {
        $product = Mage::getModel('catalog/product')->load($productId);
        $this->product_id = $productId;
        $this->entity_id = $product->getData('entity_id');
        $this->entity_type_id = $product->getData('entity_type_id');
        $this->attribute_set_id = $product->getData('attribute_set_id');
        $this->type_id = $product->getData('type_id');
        $this->category_ids = $product->getCategoryIds();

        foreach ($productAttributes as $field => $usesSource) {
            try {
                $value = $product->getData($field);
                if (is_array($value) || is_object($value)) {
                    continue;
                }

                if ($field == 'image' && $value) {
                    $imageUrl = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).'catalog/product'.$value;
                    $this->$field = $imageUrl;
                    continue;
                }

                if ($usesSource) {
                    $option = $product->getAttributeText($field);
                    if ($value && empty($option) && $option != '0') {
                        continue;
                    }
                    if (is_array($option)) {
                        $value = implode(',', $option);
                    } else {
                        $value = $option;
                    }
                }
                if ($field == 'category_ids') {
                    continue;
                }

                $this->$field = $value;
            } catch (Exception $e) {
                continue;
            }
        }

        return $this;
    }
}
