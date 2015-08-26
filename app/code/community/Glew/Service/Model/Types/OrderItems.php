<?php

class Glew_Service_Model_Types_OrderItems 
{
    public $orderItems;
    private $pageNum;

    public function load($pageSize,$pageNum,$startDate = null,$endDate = null)
    {
        $helper = Mage::helper('glew');
        $config = $helper->getConfig();
        $from = date('Y-m-d 00:00:00', strtotime($startDate));
        $to = date('Y-m-d 23:59:59', strtotime($endDate));
        
        $collection = Mage::getModel('sales/order_item')->getCollection()
            ->addAttributeToFilter('updated_at', array('from'=>$from, 'to'=>$to));
        $this->pageNum = $pageNum;
        $collection->setCurPage($pageNum);
        $collection->setPageSize($pageSize);
        if($collection->getLastPageNumber() < $pageNum){
          return $this;
        }

        foreach($collection as $orderItem) {
            if ($orderItem && $orderItem->getId()) {
                $model = Mage::getModel('glew/types_orderItem')->parse($orderItem);
                if ($model) {
                    $this->orderItems[] = $model;
                }
            }
        }

        return $this;
    }

}
