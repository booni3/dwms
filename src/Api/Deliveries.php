<?php

namespace Booni3\Dwms\Api;

class Deliveries extends Api
{
    public function getDelivery($delivery_id)
    {
        return $this->_get('get-delivery/' . $delivery_id);
    }

    public function createDelivery(
        string $supplier_name,
        string $delivery_type,
        string $carrier_name,
        string $expected_delivery,
        DeliveryItems $items
    ) {
        return $this->_post('create-delivery',[
            'supplier_name' => $supplier_name,
            'delivery_type' => $delivery_type,
            'carrier_name' => $carrier_name,
            'expected_delivery' => $expected_delivery,
            'items' => $items->toJson(),
        ]);
    }

}