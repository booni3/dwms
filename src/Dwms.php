<?php

namespace Booni3\Dwms;

class Dwms
{
    private $username;
    private $password;
    private $secret;
    private $simpleCache;

    /**
     * @param $username
     * @param $password
     * @param $secret
     * @param null $simpleCache
     */
    public function __construct($username, $password, $secret, $simpleCache = null)
    {
        $this->username = $username;
        $this->password = $password;
        $this->secret = $secret;
        $this->simpleCache = $simpleCache;
    }

    /**
     * Create instance of Client
     *
     * @param $username
     * @param $password
     * @param $secret
     * @param null $simpleCache
     * @return Dwms;
     */
    public static function make($username, $password, $secret, $simpleCache = null)
    {
        return new static ($username, $password, $secret, $simpleCache);
    }


    /**
     * Create instance of API based off method called in
     *
     * @param $method
     * @return mixed
     * @throws \ReflectionException
     */
    protected function getApiInstance($method)
    {
        $class = "\\Booni3\\Dwms\\Api\\".ucwords($method);
        if (class_exists($class) && ! (new \ReflectionClass($class))->isAbstract()) {
            return new $class($this->username, $this->password, $this->secret, $this->simpleCache);
        }
        throw new \BadMethodCallException("Undefined method [{$method}] called.");
    }

    /**
     * @return \Booni3\Dwms\Api\User
     * @throws \ReflectionException
     */
    public function User()
    {
        return $this->getApiInstance('user');
    }

    /**
     * @return \Booni3\Dwms\Api\Orders
     * @throws \ReflectionException
     */
    public function Orders()
    {
        return $this->getApiInstance('orders');
    }

    /**
     * @return \Booni3\Dwms\Api\Products
     * @throws \ReflectionException
     */
    public function Products()
    {
        return $this->getApiInstance('products');
    }

    /**
     * @return \Booni3\Dwms\Api\Products
     * @throws \ReflectionException
     */
    public function Shipments()
    {
        return $this->getApiInstance('shipments');
    }

    /**
     * @return \Booni3\Dwms\Api\Deliveries
     * @throws \ReflectionException
     */
    public function Deliveries()
    {
        return $this->getApiInstance('deliveries');
    }

    /**
     * @param $method
     * @param array $parameters
     * @throws \Exception
     * @return mixed
     */
    public function __call($method, array $parameters)
    {
        return $this->getApiInstance($method);
    }

}