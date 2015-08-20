<?php

class Glew_Service_Model_Types_Extensions 
{
    public $extensions;
    
    public function load()
    {
        $helper = Mage::helper('glew');
        $config = $helper->getConfig();

        $collection = $modules = Mage::getConfig()->getNode('modules')->children();

        foreach($collection as $extension => $attributes) {
            $model = Mage::getModel('glew/types_extension')->parse($extension, $attributes);
            if($model) {
                $this->extensions[] = $model;
            }
        }
        
        return $this;
    }
    
}
