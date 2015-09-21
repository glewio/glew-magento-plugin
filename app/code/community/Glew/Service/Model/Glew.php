<?php

class Glew_Service_Model_Glew
{

    private $_helper;
    private $_config;

    public function __construct()
    {
        $this->_helper = Mage::helper('glew');
        $this->_config = $this->_helper->getConfig();
    }

    public function createSecurityToken()
    {
        if (!$this->_isGenerated()) {
            $setup = Mage::getModel('glew/resource_mysql4_setup');
            $token = $setup->createSecurityToken($this->_helper->getDatabaseReadConnection());
            return $token;
        } else {
          return $this->_config['security_token'];
        }
    }

    private function _isGenerated()
    {
        $securityToken = $this->_config['security_token'];
        return !empty($securityToken);
    }

}
