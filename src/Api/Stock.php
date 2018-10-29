<?php

namespace Booni3\Dwms\Api;

class Stock extends Api
{
    public function getStockLevels($page = 1)
    {
        return $this->_get('get-stock-levels',[
            'page' => $page,
        ]);
    }

}