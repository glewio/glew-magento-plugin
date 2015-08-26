<?php

class Glew_Service_Model_Types_ProductAlerts
{
    public $alerts;
    private $pageNum;

    public function load($pageSize,$pageNum,$startDate = null,$endDate = null)
    {
        $config =  Mage::helper('glew')->getConfig();
        if($startDate && $endDate) {
            $filter = array(
                'datetime' => 1,
                'locale' => 'en_US',
                'from' => new Zend_Date(strtotime($startDate), Zend_Date::TIMESTAMP),
                'to' => new Zend_Date(strtotime($endDate), Zend_Date::TIMESTAMP),
            );

            $alerts = Mage::getModel('productalert/stock')->getCollection()
                ->addFieldToFilter('main_table.add_date', $filter);
        } else {
            $alerts = Mage::getModel('productalert/stock')->getCollection();
        }
        $alerts = Mage::getModel('productalert/stock')->getCollection();
        $this->pageNum = $pageNum;
        $alerts->setCurPage($pageNum);
        $alerts->setPageSize($pageSize);

        if($alerts->getLastPageNumber() < $pageNum){
            return $this;
        }

        foreach ($alerts as $alert){
            $model = Mage::getModel('glew/types_productAlert')->parse($alert);
            if ($model) {
                $this->alerts[] = $model;
            }
        }
        return $this;
    }

}
