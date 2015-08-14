<?php 

class Glew_Service_Model_Types_InventoryItem
{
    public function parse($item)
    {
    	$this->id = $item->getItemId();
    	$this->product_id = $item->getProductId();
        $this->qty = $item->getQty();
        
        return $this;
    }
    
}
