<?php

class Glew_Service_Model_Types_Subscriber
{
    public function parse($subscriber)
    {
        try {
            foreach ($subscriber->getData() as $key => $value) {
                $this->$key = $value;
            }
        } catch (Exception $e) {
            // do nothing
        }

        return $this;
    }
}
