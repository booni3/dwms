<?php


namespace Booni3\Dwms\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Redis;
use kamermans\OAuth2\GrantType\PasswordCredentials;
use kamermans\OAuth2\OAuth2Middleware;
use kamermans\OAuth2\Persistence\SimpleCacheTokenPersistence;

class Api
{
    protected $baseUri;
    protected $username;
    protected $password;
    protected $secret;

    public function __construct($baseUri, $userName, $password, $secret, $simpleCache = null)
    {
        $this->baseUri = $baseUri;
        $this->username = $userName;
        $this->password = $password;
        $this->secret = $secret;
        $this->simpleCache = $simpleCache;
    }

    protected function baseUri()
    {
        return $this->baseUri;
    }


    /**
     * {@inheritdoc}
     * @throws \Exception
     */
    public function _get($url = null, array $parameters = [])
    {
        try {
            $response = $this->getClient()->get($url, [
                'query' => $parameters,
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'Accept' => 'application/json'
                ]
            ]);
            return json_decode((string)$response->getBody(), true);
        } catch (ClientException $e) {
            $responseBodyAsString = $e->getResponse()->getBody()->getContents();
            throw new \Exception($responseBodyAsString, $response->getStatusCode());
        }
    }

    /**
     * {@inheritdoc}
     * @throws \Exception
     */
    public function _post($url = null, array $parameters = [])
    {
        try {
            $response = $this->getClient()->post($url, [
                'form_params' => $parameters,
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'Accept' => 'application/json'
                ]
            ]);
            return json_decode((string)$response->getBody(), true);
        } catch (ClientException $e) {
            $responseBodyAsString = $e->getResponse()->getBody()->getContents();


            throw new \Exception($responseBodyAsString, $e->getResponse()->getStatusCode());
        }
    }

    /**
     * Returns an Http client instance.
     *
     * @return Client
     */
    protected function getClient()
    {
        return new Client([
            'base_uri' => $this->baseUri() . '/api/v1/',
            'handler' => $this->createHandler(),
            'Accept' => 'application/json',
            'auth'    => 'oauth'
        ]);
    }

    /**
     * Create the client handler.
     *
     * @return HandlerStack
     */
    protected function createHandler()
    {
        $handler_stack = HandlerStack::create();

        // retry middleware
        $handler_stack->push(Middleware::retry(
            function ($retry, $request, $value, $reason) {
                if ($value !== null) return false; // If we have a value already, we should be able to proceed quickly.
                return $retry < 10; // reject after 10 tries
            },
            function ($retries, $response) {
                return $retries * 200; //0.2, 0.4, 0.6 seconds etc..
            }
        ));

        // oAuth middleware
        $handler_stack->push($this->oAuthMiddleware());

        // store request history middleware
        $this->container = [];
        $history = Middleware::history($this->container);
        $handler_stack->push($history);

        return $handler_stack;
    }

    /**
     * @return OAuth2Middleware
     */
    protected function oAuthMiddleware()
    {
        // Authorization client - this is used to request OAuth access tokens
        $auth_client = new Client([
            // URL for access_token request
            'base_uri' => $this->baseUri() . '/api/login/'
        ]);
        $auth_config = [
            "client_id" => "2",
            "client_secret" => $this->secret,
            "username" => $this->username,
            "password" => $this->password,
//            "scope" => "your scope(s)", // optional
//            "state" => time(), // optional
        ];

        $grant_type = new PasswordCredentials($auth_client, $auth_config);
        $oauth = new OAuth2Middleware($grant_type);

        // Set cache client
        if(isset($this->simpleCache)){
            $cache_persistance = new SimpleCacheTokenPersistence($this->simpleCache, 'dwms-oauth2-token');
            $oauth->setTokenPersistence($cache_persistance);
        }

        return $oauth;
    }

}