<?php

namespace Booni3\Dwms\Api;

class Deliveries extends Api
{
    public function getDelivery($delivery_id)
    {
        return $this->_get('get-delivery/' . $delivery_id);
    }

    public function createDelivery(
        string $delivery_type,
        string $supplier_name,
        string $supplier_ref,
        string $merchant_ref,
        string $carrier_name,
        string $expected_delivery,
        DeliveryItems $items
    ) {
        return $this->_post('create-delivery',[
            'delivery_type' => $delivery_type,
            'supplier_name' => $supplier_name,
            'supplier_ref' => $supplier_ref,
            'merchant_ref' => $merchant_ref,
            'carrier_name' => $carrier_name,
            'expected_delivery' => $expected_delivery,
            'items' => $items->toJson(),
        ]);
    }

}