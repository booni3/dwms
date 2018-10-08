<?php


namespace Booni3\Dwms\Api;


class User extends Api
{
    public function getUser()
    {
        return $this->_get('get-user');
    }
}