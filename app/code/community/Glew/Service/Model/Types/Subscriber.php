<?php 

class Glew_Service_Model_Types_Subscriber
{
    public function parseSubscriber($subscriber)
    {
    	foreach ( $subscriber->getData() as $key => $value){
    		$this->$key = $value;
    	}
        return $this;
    }
    
}
