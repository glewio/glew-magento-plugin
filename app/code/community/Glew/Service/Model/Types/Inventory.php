<?php

class Glew_Service_Model_Types_Inventory
{
    public $inventory;
    private $pageNum;

    public function load($pageSize,$pageNum)
    {
        $config =  Mage::helper('glew')->getConfig();
        $inventory = Mage::getModel('cataloginventory/stock_item')->getCollection();
        $this->pageNum = $pageNum;
        $inventory->setCurPage($pageNum);
        $inventory->setPageSize($pageSize);

        if($inventory->getLastPageNumber() < $pageNum){
            return $this;
        }

        foreach ($inventory as $inventoryItem){
            $model = Mage::getModel('glew/types_inventoryItem')->parse($inventoryItem);
            if ($model) {
                $this->inventory[] = $model;
            }
        }
        return $this;
    }

}
