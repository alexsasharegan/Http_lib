<?php

namespace Http;

class Response {

  public $body, $method, $url, $query;

  function __construct() {

    header("Content-Type: application/json");
    date_default_timezone_set("America/Phoenix");

  } # end constructor

  public function get($prop) {
    return $this->$prop;
  }

  public function set($prop, $val) {
    $this->$prop = $val;
    return $this->$prop;
  }

  public function set_array($assoc_array){
    foreach ($assoc_array as $key => $val) {
      $this->$key = $val;
    }
  }

  public function serialize() {
    return json_encode($this->body);
  }

} # end class
