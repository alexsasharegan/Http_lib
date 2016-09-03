<?php

require_once __DIR__."/child_classes/Request.class.php";
require_once __DIR__."/child_classes/Response.class.php";

class Http {

  public $request, $response, $contentType;

  function __construct() {
    $this->request = new Http\Request();
    $this->response = new Http\Response();
  }

  private function handleDefault() {
    $this->response->set_array([
      'error' => "No route has been defined for this request method.",
    ]);
    $this->send(405);
  }

  public function GET($cb) {
    $this->GET = $cb;
  }

  public function POST($cb) {
    $this->POST = $cb;
  }

  public function PUT($cb) {
    $this->PUT = $cb;
  }

  public function PATCH($cb) {
    $this->PATCH = $cb;
  }

  public function DELETE($cb) {
    $this->DELETE = $cb;
  }

  public function exec() {
    if (is_callable($this->{$this->request->method})) {
      call_user_func($this->{$this->request->method}, $this);
    } else {
      $this->handleDefault();
    }
  }

  public function send( $statusCode = 200, $contentType = 'application/json', $content = '' ) {
    header("Content-Type: $contentType;charset=UTF-8");
    date_default_timezone_set("America/Phoenix");
    http_response_code($statusCode);
    if (!empty($content)) {
      echo $content;
    } else {
      echo $this->response;
    }
    exit;
  }

  public function __toString() {
    return json_encode($this);
  }

}
