<?php

namespace Booni3\Dwms\Api;

class Orders extends Api
{
    public function getOpenOrders($entriesPerPage, $pageNumber, $filters, $sorting, $fulfilmentCenter, $additionalFilters)
    {
        return $this->_get('Orders/GetOpenOrders', [
            "entriesPerPage" => $entriesPerPage,
            "pageNumber" => $pageNumber,
            "filters" => $filters,
            "sorting" => $sorting,
            "fulfilmentCenter" => $fulfilmentCenter,
            "additionalFilters" => $additionalFilters
        ]);
    }

}