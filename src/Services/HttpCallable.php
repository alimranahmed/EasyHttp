<?php

namespace Alimranahmed\EasyHttp\Services;

abstract class HttpCallable {

    protected $client;

    public abstract function send($method, $url, $data, $headers);

    public abstract function post($url, $data = [], $headers = ["Content-Type" => "application/json"]);

    public abstract function get($url, $data = [], $headers = []);

    public abstract function put($url, $data = [], $headers = ["Content-Type" => "application/json"]);

    public abstract function delete($url, $data = [], $headers = []);

    public function getClient(){
        return $this->client;
    }

    public function logRequest($method, $url, $data, $headers){
        /*Log::info("Calling external URI... ...", __METHOD__);
        Log::info("[$method] $url");
        Log::info('Header: '.json_encode($headers));
        $logData = is_string($data) ? $data : json_encode($data);
        Log::info('Data: '.$logData);*/
    }
}