<?php

class Glew_Service_Model_Types_Categories
{
    public $categories;
    private $pageNum;

    public function load($pageSize, $pageNum, $startDate = null, $endDate = null, $sortDir)
    {
        $config =  Mage::helper('glew')->getConfig();
        if($startDate && $endDate) {
            $from = date('Y-m-d 00:00:00', strtotime($startDate));
            $to = date('Y-m-d 23:59:59', strtotime($endDate));

            $categories = Mage::getModel('catalog/category')->getCollection()
                ->addAttributeToFilter('updated_at', array('from'=>$from, 'to'=>$to));
        } else {
            $categories = Mage::getModel('catalog/category')->getCollection();
        }
        $this->pageNum = $pageNum;
        $categories->setOrder('updated_at', $sortDir);
        $categories->setCurPage($pageNum);
        $categories->setPageSize($pageSize);
        
    	if($categories->getLastPageNumber() < $pageNum){
    		return $this;
        }
        
        foreach ($categories as $category){
        	$model = Mage::getModel('glew/types_category')->parse($category);
        	if ($model) {
        		$this->categories[] = $model;
        	}   
        }
        return $this;
    }
    
}
