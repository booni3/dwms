<?php

namespace Booni3\Dwms;

class Dwms
{
    private $username;
    private $password;
    private $secret;

    /**
     * @param $username
     * @param $password
     * @param $secret
     */
    public function __construct($username, $password, $secret)
    {
        $this->username = $username;
        $this->password = $password;
        $this->secret = $secret;
    }

    /**
     * Create instance of Client
     *
     * @param $username
     * @param $password
     * @param $secret
     * @return Dwms;
     */
    public static function make($username, $password, $secret)
    {
        return new static ($username, $password, $secret);
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
            return new $class($this->username, $this->password, $this->secret);
        }
        throw new \BadMethodCallException("Undefined method [{$method}] called.");
    }


    /**
     * @return \Booni3\Dwms\Api\Auth
     * @throws \ReflectionException
     */
    public function Auth()
    {
        return $this->getApiInstance('auth');
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