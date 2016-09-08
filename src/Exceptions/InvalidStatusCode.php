<?php

namespace Http\Exceptions;

class InvalidStatusCode extends \Exception implements \JsonSerializable {

  public function __construct( $statusCode, $code = 0, Exception $previous = null ) {
    $this->statusCode = $statusCode;
    $message = "Invalid HTTP status code. Status code provided: {$statusCode}";
    parent::__construct($message, $code, $previous);
  }

  public function __toString() {
    return __CLASS__ . ". [status code: \"{$this->statusCode}\"] {$this->message}\n";
  }

  public function jsonSerialize() {
    return [
      'type'       => __CLASS__,
      'message'    => $this->message,
      'statusCode' => $this->statusCode,
    ];
  }
}
