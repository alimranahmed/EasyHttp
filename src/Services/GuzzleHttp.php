<?php

namespace AlImranAhmed\EasyHttp\Services;

use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class GuzzleHttp extends HttpCallable
{
    /**
     * @var Client
     */
    protected $client;

    public function __construct($url = null)
    {
        if (is_null($url)) {
            $this->client = new Client();
        } else {
            $this->client = new Client(['base_uri' => $url]);
        }
    }

    /**
     * @param $method
     * @param $url
     * @param $data
     * @param array $headers
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function send(string $method, string $url, $data, array $headers = ["Content-Type" => "application/json"])
    {
        $method = strtoupper($method);

        $contentType = $headers['Content-Type'] ?? ($headers['content-type'] ?? '');

        $requestTime = Carbon::now();

        $this->logRequest($method, $url, $data, $headers, 'guzzle');

        $requestData['headers'] = $headers;

        if (in_array($method, ['GET', 'DELETE'])) {
            $requestData['query'] = $data;

        } elseif (in_array($method, ['POST', 'PUT', 'PATCH'])) {

            switch (strtolower($contentType)) {
                case 'application/json':
                    $requestData['json'] = $data;
                    break;
                case 'application/x-www-form-urlencoded':
                    $requestData['form_params'] = $data;
                    break;
                case 'multipart/form-data':
                    $requestData['multipart'] = $data;
                    break;
                default:
                    $requestData['body'] = $data;
                    break;
            }
        }

        try {
            $response = $this->client->request($method, $url, $requestData);
        } catch (RequestException $e) {
            $this->logException($e);
            $response = $e->getResponse();
        }

        $responseTime = Carbon::now();
        $taken = 'Taken ' . $responseTime->diffInSeconds($requestTime) . 's';
        try {
            if (is_null($response)) {
                $status = "Response from [$method][$url] is NULL";
                Log::error("$status; $taken");
                return null;
            }
            $response->contents = $response->getBody()->getContents();

            //This is for previous getContents() call, it change the stream to last
            $response->getBody()->seek(0);
        } catch (\Exception $exception) {
            $this->logException($exception);
            return null;
        }

        $status = "Response from [$method][$url] with status: " . $response->getStatusCode() . ' ' . $response->getReasonPhrase();

        if ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300) {
            Log::info("$status; $taken\n - Body: " . $response->contents);
        } else {
            Log::error("$status; $taken\n - Body: " . $response->contents);
        }

        return $response;
    }

    private function logException(\Exception $e)
    {
        Log::error('Line: ' . $e->getLine() . ' File: ' . $e->getFile() . ' Error: ' . $e->getMessage());
    }
}
