# EasyHttp
A Laravel 5 HTTP-client to make HTTP request easier. It's a wrape on Guzzle HTTP client that simplify the common requests and log the requests and response. 

## Installation 
Update your project's `composer.json` file as bellow:

```
"require": {
    "alimranahmed/easyhttp": "dev-master"
}
```
then execute `composer update` 

That's all!

## Usages
```php
//Requesting signature/patterns
Http::requestMethod($url, $data = [], $headers = []);
 
//For GET request
$response = Http::get('www.example.com/get');
 
//For POST Request
$data = ['key' => 'value'];
$headers = ['Content-Type' => 'application/json'];
$response = Http::post('www.example.com/post', $data, $headers);
 
//For PUT request
$data = ['key' => 'value'];
$headers = ['Content-Type' => 'application/json'];
$response = Http::put('www.example.com/put', $data, $headers)
 
//For DELETE request
$response = Http::delete('www.example.com/delete');
 
//To Retrive the response status, header and body
$response->getStatusCode(); //for status code
$response->getHeaders(); //for headers
$response->contents; //for body
```

## License
This package is licensed under [Apache License, Version 2.0](http://www.apache.org/licenses/LICENSE-2.0)

