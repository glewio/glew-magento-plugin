<?php 

class Glew_Service_Model_Types_Refund
{
    public function parse($refund)
    {
        $this->refund_id = $refund->getId();
        $this->order_id = $refund->getData('order_id');;
        $this->row_total = $refund->getData('grand_total');
        $this->tax_amount = $refund->getData('tax_amount');
        $this->shipping_amount = $refund->getData('shipping_amount');
        $this->created_at = $refund->getCreatedAt();
        $this->updated_at = $refund->getUpdatedAt();

        return $this;
    }

}
