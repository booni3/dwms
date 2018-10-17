<?php

namespace Booni3\Dwms\Api;

class Shipments extends Api
{

    public function getOrder($orderId)
    {

    }

    public function getShipments($updated_from = null, $created_from = null, $updated_to = null, $created_to = null)
    {
        return $this->_get('get-shipments',[
            'updated_from' => $updated_from,
            'created_from' => $created_from,
            'updated_to' => $updated_to,
            'created_to' => $created_to,
        ]);
    }

}