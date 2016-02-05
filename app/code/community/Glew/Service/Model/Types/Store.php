<?php

class Glew_Service_Model_Types_Store
{
    public function parse($store)
    {
        try {
            foreach ($store->getData() as $key => $value) {
                $this->$key = $value;
            }
        } catch (Exception $e) {
            // do nothing
        }

        return $this;
    }
}
