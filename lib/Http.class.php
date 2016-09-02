<?php

require_once __DIR__."/child_classes/Request.class.php";
require_once __DIR__."/child_classes/Response.class.php";

class Http {

  public $request, $response;

  function __construct( $deserialize = 'application/json' ) {
    $this->request = new Http\Request($deserialize);
    $this->response = new Http\Response();
  }

  public function send($statusCode = 200) {
    http_response_code($statusCode);
    echo $this->response->serialize();
    exit;
  }

}
