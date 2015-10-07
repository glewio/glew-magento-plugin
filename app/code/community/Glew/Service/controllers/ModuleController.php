<?php

class Glew_Service_ModuleController extends Mage_Core_Controller_Front_Action
{
    protected $_helper = null;
    protected $_config = null;
    protected $_pageSize = null;
    protected $_pageNum = 0;
    protected $_startDate = null;
    protected $_endDate = null;
    protected $_sortDir = 'asc';
    protected $_filterField = 'created_at';

    protected function _construct()
    {
        $this->_helper = Mage::helper('glew');
        $this->_config = $this->_helper->getConfig();
        if (!!$pageSize = $this->getRequest()->getParam('page_size')) {
            $this->_pageSize = $pageSize;
        }
        if (!!$pageNum = $this->getRequest()->getParam('page_num')) {
            $this->_pageNum = $pageNum;
        }
        if (!!$startDate = $this->getRequest()->getParam('start_date')) {
            $this->_startDate = $startDate;
            if (!!$endDate = $this->getRequest()->getParam('end_date')) {
              $this->_endDate = $endDate;
            } else {
              $this->_endDate = date("Y-m-d");
            }
        } elseif (!!$updatedStartDate = $this->getRequest()->getParam('updated_start_date')) {
            $this->_filterField = 'updated_at';
            $this->_startDate = $updatedStartDate;
            if (!!$updatedEndDate = $this->getRequest()->getParam('updated_end_date')) {
                $this->_endDate = $updatedEndDate;
            } else {
              $this->_endDate = date("Y-m-d");
            }
        }
        if (!!$sortDir = $this->getRequest()->getParam('sort_dir')) {
            $this->_sortDir = $sortDir;
        }
    }

    public function gotoglewAction() {
        $this->_redirectUrl('https://app.glew.io');
    }

    public function abandoned_cartsAction()
    {
        try {
            $this->_initRequest();
            $collection = Mage::getModel('glew/types_abandonedCarts')->load($this->_pageSize, $this->_pageNum, $this->_startDate, $this->_endDate, $this->_sortDir, $this->_filterField);
            $this->_sendResponse($collection);
        } catch(Exception $e) {
            $this->_helper->logException($e, 'abandonedCarts');
        }
    }

    public function customersAction()
    {
        try {
            $this->_initRequest();
            $collection = Mage::getModel('glew/types_customers')->load($this->_pageSize, $this->_pageNum, $this->_startDate, $this->_endDate, $this->_sortDir, $this->_filterField);
            $this->_sendResponse($collection);
        } catch(Exception $e) {
            $this->_helper->logException($e, 'customers');
        }
    }


    public function ordersAction()
    {
        try {
            $this->_initRequest();
            $collection = Mage::getModel('glew/types_orders')->load($this->_pageSize, $this->_pageNum, $this->_startDate, $this->_endDate, $this->_sortDir, $this->_filterField);
            $this->_sendResponse($collection);
        } catch(Exception $e) {
            $this->_helper->logException($e, 'orders');
        }
    }

    public function order_itemsAction()
    {
        try {
            $this->_initRequest();
            $collection = Mage::getModel('glew/types_orderItems')->load($this->_pageSize, $this->_pageNum, $this->_startDate, $this->_endDate, $this->_sortDir, $this->_filterField);
            $this->_sendResponse($collection);
        } catch(Exception $e) {
            $this->_helper->logException($e, 'orderItems');
        }
    }

    public function storesAction()
    {
        try {
            $this->_initRequest();
            $collection = Mage::getModel('glew/types_stores')->load();
            $this->_sendResponse($collection);
        } catch(Exception $e) {
            $this->_helper->logException($e, 'stores');
        }
    }

    public function newsletter_subscribersAction()
    {
        try {
            $this->_initRequest();
            $collection = Mage::getModel('glew/types_subscribers')->load($this->_pageSize, $this->_pageNum, $this->_sortDir, $this->_filterField);
            $this->_sendResponse($collection);
        } catch(Exception $e) {
            $this->_helper->logException($e, 'subscribers');
        }
    }

    public function productsAction()
    {
        try {
            $this->_initRequest();
            $collection = Mage::getModel('glew/types_products')->load($this->_pageSize, $this->_pageNum, $this->_startDate, $this->_endDate, $this->_sortDir, $this->_filterField);
            $this->_sendResponse($collection);
        } catch(Exception $e) {
            $this->_helper->logException($e, 'products');
        }
    }

    public function product_alertsAction()
    {
        try {
            $this->_initRequest();
            $collection = Mage::getModel('glew/types_productAlerts')->load($this->_pageSize, $this->_pageNum, $this->_startDate, $this->_endDate, $this->_sortDir, $this->_filterField);
            $this->_sendResponse($collection);
        } catch(Exception $e) {
            $this->_helper->logException($e, 'productAlerts');
        }
    }

    public function categoriesAction()
    {
        try {
            $this->_initRequest();
            $collection = Mage::getModel('glew/types_categories')->load($this->_pageSize, $this->_pageNum, $this->_startDate, $this->_endDate, $this->_sortDir, $this->_filterField);
            $this->_sendResponse($collection);
        } catch(Exception $e) {
            $this->_helper->logException($e, 'categories');
        }
    }

    public function inventoryAction() {
        try {
            $this->_initRequest();
            $collection = Mage::getModel('glew/types_inventory')->load($this->_pageSize, $this->_pageNum, $this->_sortDir, $this->_filterField);
            $this->_sendResponse($collection);
        } catch(Exception $e) {
            $this->_helper->logException($e, 'inventory');
        }
    }



    public function versionAction()
    {
        try {
            $obj = new stdClass();
            $obj->version = (string)Mage::getConfig()->getNode()->modules->Glew_Service->version;
            $this->_sendResponse($obj);
        } catch(Exception $ex) {
            $this->_helper->logException($ex, 'version');
        }
    }

    public function extensionsAction()
    {
        try {
            $this->_initRequest();
            $collection = Mage::getModel('glew/types_extensions')->load($this->_pageSize, $this->_pageNum, $this->_sortDir, $this->_filterField);
            $this->_sendResponse($collection);
        } catch(Exception $e) {
            $this->_helper->logException($e, 'extensions');
        }
    }

    public function refund_itemsAction()
    {
        try {
            $this->_initRequest();
            $collection = Mage::getModel('glew/types_refundItems')->load($this->_pageSize, $this->_pageNum, $this->_startDate, $this->_endDate, $this->_sortDir, $this->_filterField);
            $this->_sendResponse($collection);
        } catch(Exception $e) {
            $this->_helper->logException($e, 'refund items');
        }
    }

    public function refundsAction()
    {
        try {
            $this->_initRequest();
            $collection = Mage::getModel('glew/types_refunds')->load($this->_pageSize, $this->_pageNum, $this->_startDate, $this->_endDate, $this->_sortDir, $this->_filterField);
            $this->_sendResponse($collection);
        } catch(Exception $e) {
            $this->_helper->logException($e, 'refunds');
        }
    }


    protected function _sendResponse($items)
    {
        $this->getResponse()->clearHeaders()->setHeader('Content-type', 'application/json', true);
        $this->getResponse()->setBody(json_encode($items));
    }

    private function _initRequest()
    {
        if(!$this->_config['enabled']) {
            $this->_reject();
            return true;
        }

        if(!$this->_config['security_token']) {
            $setup = Mage::getModel('glew/resource_mysql4_setup');
            $token = $setup->createSecurityToken();
        } else {
            $token = $this->_config['security_token'];
        }

        $authToken = (isset($_SERVER['HTTP_X_GLEW_TOKEN']) ? $_SERVER['HTTP_X_GLEW_TOKEN'] : $_SERVER['X_GLEW_TOKEN']);

        if(empty($authToken)) {
          $this->_reject();
        }

        if(trim( $token ) != trim($authToken)) {
            Mage::log('Glew feed request with invalid security token: ' . $this->getRequest()->getParam('token'));
            $this->_reject();
        }
    }

    private function _reject()
    {
        $this->getResponse()->setHttpResponseCode(401)->setBody('Invalid security token or module disabled');
        throw new Exception('Invalid security token or module disabled');
    }

}
