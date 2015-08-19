<?php 

class Glew_Service_Model_Resource_Mysql4_Setup extends Mage_Core_Model_Resource_Setup 
{

    public function createSecurityToken()
    {
        $hostname = version_compare(phpversion(),'5.3','>=') ? gethostname() : php_uname('n');
        $prefix = md5($hostname);
        sha1($prefix . rand().microtime());
        $this->_saveSecurityToken($token);
        return $token;
    }

    private function _getSecurityToken()
    {
        return  Mage::getStoreConfig('glew_settings/general/security_token');
    }
    
    private function _saveSecurityToken($token)
    {
        Mage::app()->getStore()->setConfig('glew_settings/general/security_token', $token);
        Mage::getModel('core/config')->saveConfig('glew_settings/general/security_token', $token);
    }
}
