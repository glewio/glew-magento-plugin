<?php

class Glew_Service_Model_Types_Refunds
{
    public $refunds;
    private $pageNum;

    public function load($pageSize,$pageNum,$startDate = null,$endDate = null)
    {
        $config =  Mage::helper('glew')->getConfig();
        if($startDate && $endDate) {
            $from = date('Y-m-d 00:00:00', strtotime($startDate));
            $to = date('Y-m-d 23:59:59', strtotime($endDate));

            $refunds = Mage::getResourceModel('sales/order_creditmemo_collection')
                ->addAttributeToFilter('updated_at', array('from'=>$from, 'to'=>$to));
        } else {
            $refunds = Mage::getResourceModel('sales/order_creditmemo_collection');
        }
        $refunds->getSelect()->join(array('credit_item' => sales_flat_creditmemo_item), 'credit_item.parent_id = main_table.entity_id', array('*'));
        $this->pageNum = $pageNum;
        $refunds->setCurPage($pageNum);
        $refunds->setPageSize($pageSize);
        
    	if($refunds->getLastPageNumber() < $pageNum){
    		return $this;
        }
        
        foreach ($refunds as $refund){
        	$model = Mage::getModel('glew/types_refund')->parse($refund);
        	if ($model) {
        		$this->refunds[] = $model;
        	}   
        }
        return $this;
    }
    
}
