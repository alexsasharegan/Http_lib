<?php

namespace Http;

class Request {
  public $body, $method, $url, $query;

  function __construct($mimeType) {

    $this->query = $_GET;
    $this->method = $_SERVER['REQUEST_METHOD'];
    $this->url = $_SERVER['REQUEST_URI'];

    switch ($mimeType) {
      case 'application/json':
        $this->body = json_decode(file_get_contents('php://input'), true);
        break;
      case 'application/x-www-form-urlencoded':
        $this->body = $_POST;
        break;
      case 'text/plain':
        $this->body = file_get_contents('php://input');
        break;
      default:
        $this->body = @file_get_contents('php://input');
        break;
    } # end switch

  } # end constructor

  public function get($prop) {
    return $this->$prop;
  }

}
