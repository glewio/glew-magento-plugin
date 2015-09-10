<?php

class Glew_Service_Model_Types_Orders
{
    public $orders;
    private $pageNum;
    
    public function load($pageSize, $pageNum, $startDate = null, $endDate = null, $sortDir)
    {
        $helper = Mage::helper('glew');
        $config = $helper->getConfig();

        if($startDate && $endDate) {
            $from = date('Y-m-d 00:00:00', strtotime($startDate));
            $to = date('Y-m-d 23:59:59', strtotime($endDate));
            $collection = Mage::getModel('sales/order')->getCollection()
                ->addAttributeToFilter('updated_at', array('from'=>$from, 'to'=>$to));
        } else {
            $collection = Mage::getModel('sales/order')->getCollection();
        }
        $collection->addAttributeToSort('updated_at', $sortDir);
        $collection->setCurPage($pageNum);
        $collection->setPageSize($pageSize);
        $this->pageNum = $pageNum;

        if($collection->getLastPageNumber() < $pageNum){
          return $this;
        }
        foreach($collection as $order) {
            if ($order && $order->getId()) {
                $model = Mage::getModel('glew/types_order')->parse($order);
                if ($model) {
                    $this->orders[] = $model;
                }
            }
        }
        
        return $this;
    }
    
}
