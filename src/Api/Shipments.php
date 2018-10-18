<?php

namespace Booni3\Dwms\Api;

class Shipments extends Api
{
    public function getOrder($orderId)
    {

    }

    public function getShipments($page = 1, $updated_from = null, $created_from = null, $updated_to = null, $created_to = null)
    {
        return $this->_get('get-shipments',[
            'page' => $page,
            'updated_from' => $updated_from,
            'created_from' => $created_from,
            'updated_to' => $updated_to,
            'created_to' => $created_to,
        ]);
    }

}