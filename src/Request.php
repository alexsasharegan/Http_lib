<?php

namespace Http;

class Request {

  public  $body,
          $method,
          $requestURI,
          $query,
          $file;

  function __construct() {

    $this->contentType = isset( $_SERVER['CONTENT_TYPE'] ) ? $_SERVER['CONTENT_TYPE'] : '';
    $this->cookies = isset( $_SERVER['HTTP_COOKIE'] ) ? $_SERVER['HTTP_COOKIE'] : '';;

    // PHP throws a scrict-mode warning if we don't use an interim variable
    // "Strict Standards: Only variables should be passed by reference"
    $scriptNameArray = explode( '/', $_SERVER['SCRIPT_NAME'] );
    $this->file = end( $scriptNameArray );

    $this->host = $_SERVER['HTTP_HOST'];
    $this->method = $_SERVER['REQUEST_METHOD'];
    $this->query = $_GET;
    $this->port = $_SERVER['SERVER_PORT'];
    $this->pathInfo = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
    $this->requestURI = $_SERVER['REQUEST_URI'];
    $this->scriptName = $_SERVER['SCRIPT_NAME'];
    $this->URIComponents = parse_url($_SERVER['REQUEST_URI']);
    $this->userAgent = $_SERVER['HTTP_USER_AGENT'];

    switch ( $this->contentType ) {
      case 'application/json':
        $this->body = json_decode( file_get_contents('php://input'), true );
        break;
      case 'application/x-www-form-urlencoded':
        $this->body = $_POST;
        break;
      case 'text/plain':
        $this->body = file_get_contents( 'php://input' );
        break;
      default:
        $this->body = @file_get_contents( 'php://input' );
        break;
    } # end switch

  } # end constructor

  public function get( $prop ) {
    return isset( $this->body->$prop ) ? $this->body->$prop : null;
  }

  public function __toString() {
    return json_encode( $this );
  }

} # end class