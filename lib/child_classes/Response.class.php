<?php

namespace Http;

class Response {

  private $data = [];

  function __construct($contentType) {

    header("Content-Type: $contentType;charset=UTF-8");
    date_default_timezone_set("America/Phoenix");

  } # end constructor

  public function get($prop) {
    return $this->data[$prop];
  }

  public function set($key, $val) {
    $this->data[$key] = $val;
    return $this->data[$key];
  }

  public function set_array($assoc_array){
    foreach ($assoc_array as $key => $val) {
      $this->data[$key] = $val;
    }
  }

  public function __toString() {
    return json_encode($this->data);
  }

} # end class
