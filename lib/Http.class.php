<?php

require_once __DIR__."/child_classes/Request.class.php";
require_once __DIR__."/child_classes/Response.class.php";

class Http {

  public $request, $response;

  function __construct( $contentType = 'application/json' ) {
    $this->request = new Http\Request();
    $this->response = new Http\Response($contentType);
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
    call_user_func($this->{$this->request->method}, $this);
  }

  public function send($statusCode = 200, $content = '') {
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
