# EasyHttp
A Laravel HTTP-client to make HTTP request easier

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
```
//Requesting signature/patterns
Http::requestMethod($url, $data = [], $headers = []);
 
//For GET request
$response = Http::get('www.example.com/get');
 
//For POST Request
$response = Http::post('www.example.com/post', ['key' => 'value'], ['Content-Type' => 'application/json');
 
//For PUT request
$response = Http::put('www.example.com/put', ['key' => 'value'], ['Content-Type' => 'application/json')
 
//For DELETE request
$response = Http::delete('www.example.com/delete');
 
//To Retrive the response status, header and body
$response->getStatusCode(); //for status code
$response->getHeaders(); //for headers
$response->contents; //for body
```

## License
This package is licensed under [Apache License, Version 2.0](http://www.apache.org/licenses/LICENSE-2.0)

