<?php


namespace Booni3\Dwms\Api;


class DeliveryItems
{
    protected $items = [];

    public function addItem(
        string $sku = "",
        int $qty_expected = 0
    ){
        if($qty_expected > 0){
            $this->items[] = array (
                'sku' => $sku,
                'qty_expected' => $qty_expected
            );
        }
    }

    public function toJson()
    {
        if(empty($this->items))
            throw new \Exception('No items have been added to the delivery');

        return json_encode($this->items);
    }
}