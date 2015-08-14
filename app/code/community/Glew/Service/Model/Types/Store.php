<?php 

class Glew_Service_Model_Types_Store
{
    public function parseStore($store)
    {
    	foreach ( $store->getData() as $key => $value){
    		$this->$key = $value;
    	}
        return $this;
    }

}
