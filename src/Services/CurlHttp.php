<?php

namespace AlImranAhmed\EasyHttp\Services;


use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CurlHttp extends HttpCallable
{
    public function send(string $method, string $url, $data, $headers = ["Content-Type" => "application/json"])
    {
        $method = strtoupper($method);

        $requestTime = Carbon::now();

        $this->logRequest($method, $url, $data, $headers, 'cURL');

        $builtHeader = [];
        foreach ($headers as $key => $header) {
            $builtHeader[] = "$key:$header";
        }

        $ch = curl_init();

        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => $builtHeader,
        ));

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        if (strtolower($method) == 'post') {
            $headersFirst = explode(':', $builtHeader[0]);
            if (isset($headersFirst[1]) && trim(strtolower($headersFirst[1])) == "application/json") {
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            } else {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            }
        }

        $result = curl_exec($ch);

        $responseTime = Carbon::now();
        $taken = "Taken " . $responseTime->diffInSeconds($requestTime) . 's';

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        $status = "Response from [$method][$url] with status: $httpCode";

        $response = $this->formatResponse($result, $ch, $httpCode);

        $responseLine = '- Body: ' . $response->contents;

        if ($httpCode >= 200 && $httpCode < 300) {
            Log::info("$status; $taken\n $responseLine");
        } elseif ((curl_errno($ch) || $httpCode != 200)) {
            Log::error("$status; $taken\n $responseLine");
            if (curl_error($ch)) {
                Log::error('- CURL reported error: ' . curl_error($ch));
            }
        }
        curl_close($ch);
        return $response;
    }

    private function formatResponse($result, $ch, $httpCode)
    {
        $response = new \stdClass();
        $response->contents = $result;
        $response->statusCode = $httpCode;
        return $response;
    }
}
