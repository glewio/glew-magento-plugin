<?php

class Glew_Service_Model_Types_Stores
{
    public $stores = array();
    private $pageNum;

    public function load()
    {
        $helper = Mage::helper('glew');
        $config = $helper->getConfig();

        $stores = Mage::app()->getStores();
        foreach ($stores as $store){
        	$model = Mage::getModel('glew/types_store')->parse($store);
        	if ($model) {
        		$this->stores[] = $model;
        	}
        }
        return $this;
    }

}
