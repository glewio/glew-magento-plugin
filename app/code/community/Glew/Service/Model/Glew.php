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
    
}
