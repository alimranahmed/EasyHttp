# EasyHttp
Make Http request easily and log the request and response in Laravel's default log(/storage/logs). 

This Laravel 5 HTTP-client package to make HTTP request easier. It's a wrap on Guzzle HTTP client and cURL that simplify the common 
requests. We can use Guzzle or cURL whatever we want on run time of this package.

## Installation 
Run the following command in your terminal while you are at the root of your project directory: 

```
composer require alimranahmed/easyhttp
```

That's all!

## Usages

By default all the request is made using Guzzle. 

```php
<?php
//For GET request
$response = Http::get('www.example.com/get');
 
//For POST Request
$data = ['key' => 'value'];
$headers = ['Content-Type' => 'application/json'];
$response = Http::post('www.example.com/post', $data, $headers);
 
//For PUT request
$data = ['key' => 'value'];
$headers = ['Content-Type' => 'application/json'];
$response = Http::put('www.example.com/put', $data, $headers);
 
//For DELETE request
$response = Http::delete('www.example.com/delete');
 
//To Retrieve the response status, header and body
$response->getStatusCode(); //for status code
$response->getHeaders(); //for headers
$response->contents; //for body
```

To make any request using cURL we can simply use the `using()` method as below:
 
```php
<?php
Http::using('curl')->get('www.example.com/get');
```

## License
This package is licensed under [Apache License, Version 2.0](http://www.apache.org/licenses/LICENSE-2.0)

