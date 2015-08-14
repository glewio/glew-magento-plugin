<?php 

class Glew_Service_ModuleController extends Mage_Core_Controller_Front_Action
{
    protected $_helper = null;
    protected $_config = null;
    protected $_pageSize = null;
    protected $_pageNum = null;
    protected $_startDate = null;
    protected $_endDate = null;

    protected function _construct()
    {
        $this->_helper = Mage::helper('glew');
        $this->_config = $this->_helper->getConfig();
        if (!!$pageSize = $this->getRequest()->getParam('pageSize')){
            $this->_pageSize = $pageSize;
        }
        if (!!$pageNum = $this->getRequest()->getParam('pageNum')){
            $this->_pageNum = $pageNum;
        }
        if (!!$startDate = $this->getRequest()->getParam('startDate')){
            $this->_startDate = $startDate;
        }
        if (!!$endDate = $this->getRequest()->getParam('endDate')){
            $this->_endDate = $endDate;
        }
    }

    public function gotoglewAction() {
        $this->_redirectUrl('https://app.glew.io');
    }

    public function abandoned_cartsAction()
    {
        try {
            $this->_initRequest();
            $collection = Mage::getModel('glew/types_abandonedCarts')->load($this->_pageSize, $this->_pageNum,$this->_startDate, $this->_endDate);
            $this->_sendResponse($collection);
        } catch(Exception $ex) {
            $this->_helper->ex($ex, 'abandonedCarts');
        }
    }
    
    public function customersAction()
    {
        try {
            $this->_initRequest();
            $collection = Mage::getModel('glew/types_customers')->load($this->_pageSize,$this->_pageNum,$this->_startDate,$this->_endDate);
            $this->_sendResponse($collection);
        } catch(Exception $ex) {
            $this->_helper->ex($ex, 'customers');
        }
    }

    
    public function ordersAction()
    {
        try {
            $this->_initRequest();
            $collection = Mage::getModel('glew/types_orders')->load($this->_pageSize,$this->_pageNum,$this->_startDate,$this->_endDate);
            $this->_sendResponse($collection);
        } catch(Exception $ex) {
            $this->_helper->ex($ex, 'orders');
        }
    }
    
    public function order_itemsAction()
    {
        try {
            $this->_initRequest();
            $collection = Mage::getModel('glew/types_orderItems')->load($this->_pageSize,$this->_pageNum,$this->_startDate,$this->_endDate);
            $this->_sendResponse($collection);
        } catch(Exception $ex) {
            $this->_helper->ex($ex, 'orderItems');
        }
    }

    public function storesAction()
    {
        try {
            $this->_initRequest();
            $collection = Mage::getModel('glew/types_stores')->load();
            $this->_sendResponse($collection);
        } catch(Exception $ex) {
            $this->_helper->ex($ex, 'stores');
        }
    }

    public function newsletter_subscribersAction()
    {
        try {
            $this->_initRequest();
            $collection = Mage::getModel('glew/types_subscribers')->load($this->_pageSize,$this->_pageNum);
            $this->_sendResponse($collection);
        } catch(Exception $ex) {
            $this->_helper->ex($ex, 'subscribers');
        }
    }

    public function productsAction()
    {
        try {
            $this->_initRequest();
            $collection = Mage::getModel('glew/types_products')->load($this->_pageSize,$this->_pageNum,$this->_startDate,$this->_endDate);
            $this->_sendResponse($collection);
        } catch(Exception $ex) {
            $this->_helper->ex($ex, 'products');
        }
    }

    public function product_alertsAction()
    {
        try {
            $this->_initRequest();
            $collection = Mage::getModel('glew/types_productAlerts')->load($this->_pageSize,$this->_pageNum,$this->_startDate,$this->_endDate);
            $this->_sendResponse($collection);
        } catch(Exception $ex) {
            $this->_helper->ex($ex, 'productAlerts');
        }
    }

    public function categoriesAction()
    {
        try {
            $this->_initRequest();
            $collection = Mage::getModel('glew/types_categories')->load($this->_pageSize,$this->_pageNum,$this->_startDate,$this->_endDate);
            $this->_sendResponse($collection);
        } catch(Exception $ex) {
            $this->_helper->ex($ex, 'categories');
        }
    }

    public function inventoryAction() {
        try {
            $this->_initRequest();
            $collection = Mage::getModel('glew/types_inventory')->load($this->_pageSize,$this->_pageNum,$this->_startDate,$this->_endDate);
            $this->_sendResponse($collection);
        } catch(Exception $ex) {
            $this->_helper->ex($ex, 'inventory');
        }
    }


    
    public function versionAction()
    {
        try {
            $obj = new stdClass();
            $obj->version = Mage::getConfig()->getNode()->modules->Glew_Service->version;
            $this->_sendResponse($obj);
        } catch(Exception $ex) {
            $this->_helper->ex($ex, 'version');
        }
    }
    

    protected function _sendResponse($items)
    {
        $this->getResponse()->clearHeaders()->setHeader('Content-type', 'application/json', true);
        $this->getResponse()->setBody(json_encode($items));
    }
    
    private function _initRequest()
    {
        if (! $this->_config['enabled']) {
            $this->_reject();
            return true;
        }       
        if (! $this->_config['security_token']) {
            $setup = Mage::getModel('glew/resource_mysql4_setup');
            $setup->createSecurityToken();
        }
        if (trim( $this->_config['security_token']) != trim($this->getRequest()->getParam('token'))) {
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
