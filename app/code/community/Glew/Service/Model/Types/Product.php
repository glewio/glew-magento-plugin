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

        foreach ( $productAttributes as $field => $usesSource){
            $value = $product->getData($field);
            if(is_array($value) || is_object($value)){
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
            if($field == 'category_ids'){
                $value = $product->getCategoryIds();
            }

    		$this->$field = $value;
    	}

        return $this;
    }

}
