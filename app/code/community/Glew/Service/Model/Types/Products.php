<?php

class Glew_Service_Model_Types_Products
{
    public $products;
    public $productAttributes = array();

    public function load($pageSize,$pageNum,$startDate = null,$endDate = null)
    {
        $config =  Mage::helper('glew')->getConfig();
        $this->_getProductAttribtues();
        $from = date('Y-m-d 00:00:00', strtotime($startDate));
        $to = date('Y-m-d 23:59:59', strtotime($endDate));

        $products = Mage::getModel('catalog/product')->getCollection()->addAttributeToSelect('*')
            ->addAttributeToFilter('updated_at', array('from'=>$from, 'to'=>$to));
        $this->pageNum = $pageNum;
        $products->setCurPage($pageNum);
        $products->setPageSize($pageSize);
        
    	if($products->getLastPageNumber() < $pageNum){
    		return $this;
        }
        
        foreach ($products as $product){
            $productId = $product->getId();
            $model = Mage::getModel('glew/types_product')->parseProduct($productId, $this->productAttributes);
        	if ($model) {
        		$this->products[] = $model;
        	}   
        }
        return $this;
    }

    protected function _getProductAttribtues()
    {
        if(!$this->productAttributes){
            $attributes = Mage::getResourceModel('catalog/product_attribute_collection')->getItems();
            foreach ($attributes as $attribute){
                if (!$attribute) {
                    continue;
                }
                $this->productAttributes[$attribute->getData('attribute_code')] = $attribute->usesSource();
            }
        }
    }

    
}
