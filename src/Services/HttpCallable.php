<?php

namespace Alimranahmed\EasyHttp\Services;

use Illuminate\Support\Facades\Log;

abstract class HttpCallable
{

    protected $client;

    public abstract function send($method, $url, $data, $headers);

    public function post($url, $data = [], $headers = ["Content-Type" => "application/json"]) {
        return $this->send('POST', $url, $data, $headers);
    }

    public function get($url, $data = [], $headers = []) {
        return $this->send('GET', $url, $data, $headers);
    }

    public function put($url, $data = [], $headers = ["Content-Type" => "application/json"]) {
        return $this->send('PUT', $url, $data, $headers);
    }

    public function delete($url, $data = [], $headers = []) {
        return $this->send('DELETE', $url, $data, $headers);
    }

    public function logRequest($method, $url, $data, $headers) {
        Log::info("Requesting [$method] $url ... ...");
        Log::info('Header: '.json_encode($headers));
        $logData = is_string($data) ? $data : json_encode($data);
        Log::info('Data: '.$logData);
    }
}