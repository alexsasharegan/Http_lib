# Http
[![Latest Stable Version](https://poser.pugx.org/alexsasharegan/http/v/stable)](https://packagist.org/packages/alexsasharegan/http)
[![Total Downloads](https://poser.pugx.org/alexsasharegan/http/downloads)](https://packagist.org/packages/alexsasharegan/http)
[![Latest Unstable Version](https://poser.pugx.org/alexsasharegan/http/v/unstable)](https://packagist.org/packages/alexsasharegan/http)
[![License](https://poser.pugx.org/alexsasharegan/http/license)](https://packagist.org/packages/alexsasharegan/http)

A lightweight, dependency free library that makes writing file-based RESTful JSON API endpoints easier in PHP.

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

```php
<?php

$http = new Http;
```

## Properties

Properties for class `Http` represented in json:

```json
{
  "request": "type: class Http\Request",
  "response": "type: class Http\Response",
  "get": "type: callable (callback handle)",
  "post": "type: callable (callback handle)",
  "put": "type: callable (callback handle)",
  "patch": "type: callable (callback handle)",
  "delete": "type: callable (callback handle)"
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

The `Http` class has a method available for each major HTTP verb _(get, post, put, patch, delete)_. These allow you to attach your callbacks to be run on each appropriate request method. You can pass in the string name of your callback, or write your function inline as a closure. The callback will be called with the instance of `Http`.

#### Callback Reference

```php
<?php  

function myPostCallback($http) {
  # code ...
}

$http = new Http;
$http->post('myPostCallback');
```

#### Inline Closure

```php
<?php  

$http = new Http;
$http->post(
  function ($http) {
    # code ...
  }
);

# also possible
$myGlobalVar = [1,2,3];
(new Http)
  ->get(
    function ($http) {
      # code ...
    }
  )
  ->post(
    function ($http, $myGlobalVar) {
      # code ...
    }
    , $myGlobalVar
  )
  ->exec();
```

To get values off the parsed request body, call `Http\Request::get( string $key )`.

When writing your callbacks, you can build up your response with two methods:

  - `Http\Response::set( string $key, mixed $value )`

    ##### Parameters
    * **key:** the name for the value you wish to set
    * **value:** the value you wish to set

  - `Http\Response::set_array( array $array )`

    ##### Parameters
    * **array:** an associative array of values to set on the response

The last line in your callback will be a call to `Http::send`. This exits execution completely after sending the response.

  - `Http::send( [ int $statusCode = 200, string $contentType = "application/json", string $content = '' ] )`

    ##### Parameters
    * **statusCode:** a valid HTTP status code to return
    * **contentType:** a valid MIME Type to set the response header
    * **content:** if you set Content-Type to something other than json, you can send your custom data with this parameter. No serialization will be performed on this content.
    * **_Note:_** any undefined routes will return a status code `405` with a json formatted error message
    ```json
      {
        "error": "No route has been defined for this request method."
      }
    ```

If you use a `try {} catch(Exception $e) {}` block in your error handling, you can call `Http::handleError( Exception $e )` in your catch block, and it will automatically reply with a `500` code and a json payload containing the error.

Once you have defined all your necessary HTTP method callbacks, you can let your instance of `Http` run the appropriate callback by simply calling:

```php
<?php

$http->exec();
```

## Examples

```php
<?php
# this example uses the Database and Html library as well
require_once 'path/to/vendor/autoload.php';

# alias our classes for cleanliness
use Database\MySQL;
use Http\Http;
use Html\Html;

# the callbacks for each http method
# get called with the instance of Http\Http
function get($http) {
  # instantiate our MySQL object with a connection config
  $db = new MySQL([
    'hostName'     => '1.1.1.1',
    'databaseName' => 'myDatabase',
    'dbUserName'   => 'admin',
    'dbPassword'   => 'adminPass',
  ]);

  # make a select query and pull $id from the request query string
  $db->query(
    "SELECT * FROM `sellers` WHERE `id` = {$http->request->query('id')}"
  )
  # this func gets called once for each row
  # 'use' pulls in $http from the closure's parent scope
  # sometimes we need to pass by reference like this: use( &$var )
  ->iterateResult(
    function ( $row ) use ( $http ){
      $http->response->set_array($row);
    }
  );
  # nesting operations to dumb the column names into response['sellers']
  $http->response->set( 'sellersColumns', $db->getColumns('sellers') );
  # test setting different types
  $http->response->set( 'test', [
    'one' => 1,
    'two' => 'two',
    'three' => true,
    'four' => [1,2,3],
  ]);
  # send what's in our response object
  $http->send();
}

# make our instance of Http\Http
$http = new Http;
# chain our calls together
$http
  ->get( 'get' )
  ->post(
    function ( $http ) {
      # code ...
    }
  )
  # there is a default exception handler,
  # but you can set a custom exception handler
  # like this:
  ->error(
    function ( Exception $e ) use ( $http ) {
      $http->send(500, 'text/html', new Html('code', $e));
    }
  )
  # execute the route
  ->exec();
```

```php
<?php

require_once 'path/to/vendor/autoload.php';
use Http\Http;
use Http\Response;

Http::redirect('/index.html');
# this sends the location header & exits execution!
# the redirect location defaults to '/'

$current_http_status = Http::status();
# calling it without any arguments gets the current status code

$prev_http_status = Http::status(404);
# setting a new status will set the response code and return the old status

Http::status(Response::HTTP_NOT_FOUND);
# there are a number of constants available for valid status codes
# while it can be verbose, it can add readability to your code
# here is the fully namespaced list:
Http\Response::HTTP_CONTINUE = 100;
Http\Response::HTTP_SWITCHING_PROTOCOLS = 101;
Http\Response::HTTP_PROCESSING = 102;            // RFC2518
Http\Response::HTTP_OK = 200;
Http\Response::HTTP_CREATED = 201;
Http\Response::HTTP_ACCEPTED = 202;
Http\Response::HTTP_NON_AUTHORITATIVE_INFORMATION = 203;
Http\Response::HTTP_NO_CONTENT = 204;
Http\Response::HTTP_RESET_CONTENT = 205;
Http\Response::HTTP_PARTIAL_CONTENT = 206;
Http\Response::HTTP_MULTI_STATUS = 207;          // RFC4918
Http\Response::HTTP_ALREADY_REPORTED = 208;      // RFC5842
Http\Response::HTTP_IM_USED = 226;               // RFC3229
Http\Response::HTTP_MULTIPLE_CHOICES = 300;
Http\Response::HTTP_MOVED_PERMANENTLY = 301;
Http\Response::HTTP_FOUND = 302;
Http\Response::HTTP_SEE_OTHER = 303;
Http\Response::HTTP_NOT_MODIFIED = 304;
Http\Response::HTTP_USE_PROXY = 305;
Http\Response::HTTP_RESERVED = 306;
Http\Response::HTTP_TEMPORARY_REDIRECT = 307;
Http\Response::HTTP_PERMANENTLY_REDIRECT = 308;  // RFC7238
Http\Response::HTTP_BAD_REQUEST = 400;
Http\Response::HTTP_UNAUTHORIZED = 401;
Http\Response::HTTP_PAYMENT_REQUIRED = 402;
Http\Response::HTTP_FORBIDDEN = 403;
Http\Response::HTTP_NOT_FOUND = 404;
Http\Response::HTTP_METHOD_NOT_ALLOWED = 405;
Http\Response::HTTP_NOT_ACCEPTABLE = 406;
Http\Response::HTTP_PROXY_AUTHENTICATION_REQUIRED = 407;
Http\Response::HTTP_REQUEST_TIMEOUT = 408;
Http\Response::HTTP_CONFLICT = 409;
Http\Response::HTTP_GONE = 410;
Http\Response::HTTP_LENGTH_REQUIRED = 411;
Http\Response::HTTP_PRECONDITION_FAILED = 412;
Http\Response::HTTP_REQUEST_ENTITY_TOO_LARGE = 413;
Http\Response::HTTP_REQUEST_URI_TOO_LONG = 414;
Http\Response::HTTP_UNSUPPORTED_MEDIA_TYPE = 415;
Http\Response::HTTP_REQUESTED_RANGE_NOT_SATISFIABLE = 416;
Http\Response::HTTP_EXPECTATION_FAILED = 417;
Http\Response::HTTP_I_AM_A_TEAPOT = 418;                                               // RFC2324
Http\Response::HTTP_MISDIRECTED_REQUEST = 421;                                         // RFC7540
Http\Response::HTTP_UNPROCESSABLE_ENTITY = 422;                                        // RFC4918
Http\Response::HTTP_LOCKED = 423;                                                      // RFC4918
Http\Response::HTTP_FAILED_DEPENDENCY = 424;                                           // RFC4918
Http\Response::HTTP_RESERVED_FOR_WEBDAV_ADVANCED_COLLECTIONS_EXPIRED_PROPOSAL = 425;   // RFC2817
Http\Response::HTTP_UPGRADE_REQUIRED = 426;                                            // RFC2817
Http\Response::HTTP_PRECONDITION_REQUIRED = 428;                                       // RFC6585
Http\Response::HTTP_TOO_MANY_REQUESTS = 429;                                           // RFC6585
Http\Response::HTTP_REQUEST_HEADER_FIELDS_TOO_LARGE = 431;                             // RFC6585
Http\Response::HTTP_UNAVAILABLE_FOR_LEGAL_REASONS = 451;
Http\Response::HTTP_INTERNAL_SERVER_ERROR = 500;
Http\Response::HTTP_NOT_IMPLEMENTED = 501;
Http\Response::HTTP_BAD_GATEWAY = 502;
Http\Response::HTTP_SERVICE_UNAVAILABLE = 503;
Http\Response::HTTP_GATEWAY_TIMEOUT = 504;
Http\Response::HTTP_VERSION_NOT_SUPPORTED = 505;
Http\Response::HTTP_VARIANT_ALSO_NEGOTIATES_EXPERIMENTAL = 506;                        // RFC2295
Http\Response::HTTP_INSUFFICIENT_STORAGE = 507;                                        // RFC4918
Http\Response::HTTP_LOOP_DETECTED = 508;                                               // RFC5842
Http\Response::HTTP_NOT_EXTENDED = 510;                                                // RFC2774
Http\Response::HTTP_NETWORK_AUTHENTICATION_REQUIRED = 511;
```
