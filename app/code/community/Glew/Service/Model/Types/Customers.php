<?php

class Glew_Service_Model_Types_Customers 
{
    public $customers;
    private $pageNum;
    
    public function load($pageSize,$pageNum,$startDate = null,$endDate = null)
    {
        $helper = Mage::helper('glew');
        $config = $helper->getConfig();
        if($startDate && $endDate) {
            $from = date('Y-m-d 00:00:00', strtotime($startDate));
            $to = date('Y-m-d 23:59:59', strtotime($endDate));

            $collection = Mage::getModel('customer/customer')->getCollection()
                ->addAttributeToFilter('updated_at', array('from'=>$from, 'to'=>$to));
        } else {
            $collection = Mage::getModel('customer/customer')->getCollection();
        }
        $collection->setCurPage($pageNum);
        $collection->setPageSize($pageSize);
        $this->pageNum = $pageNum;

        if($collection->getLastPageNumber() < $pageNum){
          return $this;
        }
        foreach($collection as $customer) {
            $customer = Mage::getModel('customer/customer')->load($customer->getId());
            if ($customer && $customer->getId()) {
                $model = Mage::getModel('glew/types_customer')->parse($customer);
                if ($model) {
                    $this->customers[] = $model;
                }
            }
        }
        
        return $this;
    }
    
}
