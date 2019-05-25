<?php

namespace AlImranAhmed\EasyHttp\Services;

use Illuminate\Support\Facades\Log;

abstract class HttpCallable
{
    public abstract function send(string $method, string $url, $data, $headers);

    public function post($url, $data = [], $headers = ["Content-Type" => "application/json"])
    {
        return $this->send('POST', $url, $data, $headers);
    }

    public function get($url, $data = [], $headers = [])
    {
        return $this->send('GET', $url, $data, $headers);
    }

    public function put($url, $data = [], $headers = ["Content-Type" => "application/json"])
    {
        return $this->send('PUT', $url, $data, $headers);
    }

    public function delete($url, $data = [], $headers = [])
    {
        return $this->send('DELETE', $url, $data, $headers);
    }

    protected function logRequest(string $method, string $url, $data, $headers, $client)
    {
        $request = "Outgoing Request [$method][$url] using $client...";
        $header = '- Headers: ' . json_encode($headers);
        $logData = '- Body: ' . (is_string($data) ? $data : json_encode($data));
        Log::info("{$request}\n {$header}\n {$logData}");
    }
}
