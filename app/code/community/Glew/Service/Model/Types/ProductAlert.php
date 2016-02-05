<?php

class Glew_Service_Model_Types_ProductAlert
{
    public function parse($alert)
    {
        try {
            $this->id = $alert->getAlertStockId();
            $this->customer_id = $alert->getCustomerId();
            $this->product_id = $alert->getProductId();
            $this->created_at = $alert->getAddDate();
        } catch (Exception $e) {
            // do nothing
        }

        return $this;
    }
}
