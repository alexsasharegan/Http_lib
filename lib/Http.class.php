<?php

class Http {

  public $method, $req, $res, $url;

  function __construct() {
    header('Content-Type: application/json');
    date_default_timezone_set("America/Phoenix");
    $this->method = $_SERVER['REQUEST_METHOD'];
    $this->req = json_decode(file_get_contents('php://input'),TRUE);
    $this->url = $_SERVER['REQUEST_URI'];
  }

  public function sendJSON($statusCode = 200) {
    http_response_code($statusCode);
    $json = json_encode($this->$res);
    echo $data;
    exit;
  }

}
