<?php


namespace AlImranAhmed\EasyHttp\Services;

class HttpHandler
{
    /**
     * @var HttpCallable
     */
    protected $httpCallable;

    /**
     * @var string
     */
    protected $client = 'guzzle';

    public function __construct()
    {
        $this->resolvedClientClass();
    }

    public function __call($name, $arguments)
    {
        $response = call_user_func_array([$this->httpCallable, $name], $arguments);
        $this->client = 'guzzle';
        $this->resolvedClientClass();
        return $response;
    }

    public function using($client)
    {
        if(!in_array($client, ['curl', 'guzzle'])){
            throw new \InvalidArgumentException('Only curl or guzzle can be used as client');
        }
        $this->client = $client;
        $this->resolvedClientClass();
        return $this;
    }

    private function resolvedClientClass(): HttpCallable
    {
        $clientClass = ucfirst(strtolower($this->client)) . 'Http';
        $fullClassPath = __NAMESPACE__ . "\\$clientClass";
        $this->httpCallable = new $fullClassPath();
        return $this->httpCallable;
    }
}
