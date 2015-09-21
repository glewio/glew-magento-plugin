<?php

class Glew_Service_Block_SecretKey extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $this->setElement($element);
        $helper = Mage::helper('glew');
        $config = $helper->getConfig();
        $glew = Mage::getModel('glew/glew');
        if(!$config['security_token']) {
          $token = $glew->createSecurityToken();
        } else {
          $token = $config['security_token'];
        }

        return trim($token);
    }
}
