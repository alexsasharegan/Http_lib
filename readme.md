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

An instance of `Http` can be called two ways: with a valid MIME Type or without. Instantiation without a type defaults to `json`, but it can be overridden. These MIME Types are supported:

  - **_default:_** `application/json` _(parsed into associative array)_
  - `application/xxx-form-urlencoded` *(equivalent to $_POST array)*
  - `text/plain` _(gets data as a string)_

```php
<?php

require_once 'path/to/Http_Autoloader.php';

$http = new Http;
# new instance defaults to 'application/json'

$http = new Http('application/xxx-form-urlencoded');
# new instance sets MIME Type
```

## Properties

```php
<?php

$http->request->body; #type: mixed
# the deserialized data from the request

$http->request->method; # type: string
# i.e. GET, POST, PUT, PATCH, DELETE
```

## Methods
