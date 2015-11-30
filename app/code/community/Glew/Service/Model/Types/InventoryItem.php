<?php

class Glew_Service_Model_Types_InventoryItem
{
    public function parse($item)
    {
      $product = Mage::getModel('catalog/product')->load($item->getProductId());
    	$this->id = $item->getItemId();
    	$this->product_id = $item->getProductId();
      $this->qty = $item->getQty();
      $this->price = $product->getPrice();
      $this->cost = $product->getCost();

      return $this;
    }

}
