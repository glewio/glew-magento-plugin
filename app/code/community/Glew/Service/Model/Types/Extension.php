<?php

class Glew_Service_Model_Types_Extension
{
    public function parse($extension, $attr)
    {
        try {
            $this->name = $extension;
            $this->active = (string) $attr->active;
            $this->version = (string) $attr->version;
        } catch (Exception $e) {
            // do nothing
        }
        return $this;
    }
}
