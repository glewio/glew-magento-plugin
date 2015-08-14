<?php

class Glew_Service_Model_Types_Subscribers
{
    public $subscribers;
    
    public function load($pageSize,$pageNum)
    {
        $helper = Mage::helper('glew');
        $config = $helper->getConfig();
        $subscribers = Mage::getModel('newsletter/subscriber')->getCollection();
        $this->pageNum = $pageNum;
        $subscribers->setCurPage($pageNum);
        $subscribers->setPageSize($pageSize);
        
    	if($subscribers->getLastPageNumber() < $pageNum){
    		return $this;
        }
        
        foreach ($subscribers as $subscriber){
        	$model = Mage::getModel('glew/types_subscriber')->parseSubscriber($subscriber);
        	if ($model) {
        		$this->subscribers[] = $model;   
        	}   
        }
        return $this;
    }
    
}
