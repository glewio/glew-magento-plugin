<?php

class Glew_Service_Model_Types_OrderItems
{
    public $orderItems = array();
    private $pageNum;

    public function load($pageSize, $pageNum, $startDate = null, $endDate = null, $sortDir, $filterBy)
    {
        $helper = Mage::helper('glew');
        $config = $helper->getConfig();
        $this->pageNum = $pageNum;

        $attribute = Mage::getSingleton('eav/config')->getAttribute(Mage_Catalog_Model_Product::ENTITY, 'cost');
        if($startDate && $endDate) {
            $from = date('Y-m-d 00:00:00', strtotime($startDate));
            $to = date('Y-m-d 23:59:59', strtotime($endDate));

            $collection = Mage::getModel('sales/order_item')->getCollection()
                ->addAttributeToFilter($filterBy, array('from'=>$from, 'to'=>$to));
        } else {
            $collection = Mage::getModel('sales/order_item')->getCollection();
        }
        $collection->addAttributeToFilter('main_table.store_id', $helper->getStore()->getStoreId());
        $resource = Mage::getSingleton('core/resource');
        $catProdEntDecTable = $resource->getTableName('catalog_product_entity_decimal');
        $collection->getSelect()->joinLeft(
            array('cost' => $catProdEntDecTable),
            "main_table.product_id = cost.entity_id AND cost.attribute_id = {$attribute->getId()}",
            array('cost' => 'value')
        );
        $collection->setOrder('created_at', $sortDir);
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
