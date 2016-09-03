# Http

The goal is to write a helpful set of classes that make writing RESTful JSON API's easier in PHP.

## Setup

Clone the repo into your project. Assuming your restful endpoints live in an `/api` directory, I would recommend either making an `/api/vendor` folder or just a plain `/api/libs` folder and cloning this repo inside there.

- In your project, `require_once` the path to the `Http_Autoloader.php`.

```php
<?php

require_once 'path/to/Http_Autoloader.php';

# ...or potentially...

require_once 'project_root/dist/api/vendor/Http_lib/Http_Autoloader.php';
```

## Instantiation

You can create an instance of `Http` with no arguments for a json response. Pass in a valid MIME Type to automatically set the outgoing "Content-Type" header.

```php
<?php

$http = new Http;
# new instance defaults to 'application/json'

$http = new Http('text/html');
# new instance sets the Content-Type header to "text/html;charset=UTF-8"
```

## Properties

Properties for class `Http` represented in json:

```json
{
  "request": "type: class Http\Request",
  "response": "type: class Http\Response",
  "GET": "type: callable (callback handle)",
  "POST": "type: callable (callback handle)",
  "PUT": "type: callable (callback handle)",
  "PATCH": "type: callable (callback handle)",
  "DELETE": "type: callable (callback handle)"
}
```

Some example properties for the class `Http\Request` represented in json (they vary based on the request itself):

```json
{
  "body": {
    "content": "this is some test content from a json request"
  },
  "method": "POST",
  "requestURI": "/php/my_libs_tests/Http.test.php/1?stuff=some+stuff",
  "query": {
    "stuff": "some stuff"
  },
  "file": "Http.test.php",
  "contentType": "application/json",
  "cookies": "PHPSESSID=01kf9mqndmpr8guqe6tk87nka7; _ga=GA1.1.162483231.1471457216",
  "host": "localhost",
  "port": "80",
  "pathInfo": "/1",
  "scriptName": "/php/my_libs_tests/Http.test.php",
  "URIComponents": {
    "path": "/php/my_libs_tests/Http.test.php/1",
    "query": "stuff=some+stuff"
  },
  "userAgent": "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36"
}
```

Properties for `Http\Reponse` are private. This allows the response object to manage the response data and serialize it on send.

## Methods

The `Http` class has a method available for each major HTTP verb _(GET, POST, PUT, PATCH, DELETE)_. These allow you to attach your callbacks to be run on each appropriate request method. You can pass in the string name of your callback, or write your function inline as a closure. The callback will be called with the instance of `Http`.

#### Callback Reference

```php
<?php  

function myPostCallback($http) {
  # code ...
}

$http = new Http;
$http->POST('myPostCallback');

```

#### Inline Closure

```php
<?php  

$http = new Http;
$http->POST(
  function ($http) {
    # code ...
  }
);

```

When writing your callbacks, you can build up your response with two methods:

  - `Http\Response::set( string $key, mixed $value )`

    ##### Parameters
    * **key:** the name for the value you wish to set
    * **value:** the value you wish to set

  - `Http\Response::set_array( array $array )`

    ##### Parameters
    * **array:** an associative array of values to set on the response

The last line in your callback will be a call to `Http::send`. This exits execution after sending the response.

- `Http::send( int $statusCode = 200 [, string $content = '' ] )`

  ##### Parameters
  * **statusCode:** a valid HTTP status code to return _(defaults to 200)_
  * **content:** if you set Content-Type to something other than json, you can send your custom data with this parameter. No serialization will be performed on this content.

Once you have defined all your necessary HTTP method callbacks, you can let your instance of `Http` run the appropriate callback by simply calling:

```php
<?php

$http->exec();
```
