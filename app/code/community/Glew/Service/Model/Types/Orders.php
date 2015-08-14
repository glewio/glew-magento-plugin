<?php

class Glew_Service_Model_Types_Orders
{
    public $orders; 
    
    public function load($pageSize,$pageNum)
    {
        $helper = Mage::helper('glew');
        $config = $helper->getConfig();
        
        $collection = Mage::getModel('sales/order')->getCollection();
        $collection->setCurPage($pageNum);
        $collection->setPageSize($pageSize);
        $this->pageNum = $pageNum;

        if($collection->getLastPageNumber() < $pageNum){
          return $this;
        }
        foreach($collection as $order) {
            if ($order && $order->getId()) {
                $model = Mage::getModel('glew/types_order')->parseOrder($order);
                if ($model) {
                    $this->orders[] = $model;
                }
            }
        }
        
        return $this;
    }
    
}
