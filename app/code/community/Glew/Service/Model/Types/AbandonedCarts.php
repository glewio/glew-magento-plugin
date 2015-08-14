<?php

class Glew_Service_Model_Types_AbandonedCarts
{
    public $carts;

    public function load($pageSize,$pageNum,$startDate = null,$endDate = null)
    {
        $helper = Mage::helper('glew');
        $config = $helper->getConfig();
        if($startDate && $endDate) {
	        $filter = array(
	            'datetime' => 1,
	            'locale' => 'en_US',
	            'from' => new Zend_Date(strtotime($startDate), Zend_Date::TIMESTAMP),
				'to' => new Zend_Date(strtotime($endDate), Zend_Date::TIMESTAMP),
			);

	        $collection = Mage::getResourceModel('reports/quote_collection')
	            ->addFieldToFilter('main_table.updated_at', $filter);
        } else {
        	$collection = Mage::getResourceModel('reports/quote_collection');
        }
        $collection->prepareForAbandonedReport();
        $collection->setCurPage($pageNum);
        $collection->setPageSize($pageSize);
        $this->pageNum = $pageNum;

        if($collection->getLastPageNumber() < $pageNum){
          return $this;
        }

        foreach($collection as $cart) {
            if ($cart) {
                $model = Mage::getModel('glew/types_abandonedCart')->parseCart($cart);
                if ($model) {
                    $this->carts[] = $model;
                }
            }
        }

        return $this;
    }

}
