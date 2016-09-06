<?php

namespace Http;

class Http {

  public $request, $response, $contentType;

  function __construct() {
    date_default_timezone_set("America/Phoenix");

    $this->request = new Request;
    $this->response = new Response;
  }

  private function handleDefault() {
    $this->response->set_array([
      'error' => "No route has been defined for this request method.",
    ]);
    $this->send(405);
  }

  public function get( $cb ) {
    $args = array_slice( func_get_args(), 1 );
    $this->GETParams = $args;
    $this->GET = $cb;
    return $this;
  }

  public function post( $cb ) {
    $args = array_slice( func_get_args(), 1 );
    $this->POSTParams = $args;
    $this->POST = $cb;
    return $this;
  }

  public function put( $cb ) {
    $args = array_slice( func_get_args(), 1 );
    $this->PUTParams = $args;
    $this->PUT = $cb;
    return $this;
  }

  public function patch( $cb ) {
    $args = array_slice( func_get_args(), 1 );
    $this->PATCHParams = $args;
    $this->PATCH = $cb;
    return $this;
  }

  public function delete( $cb ) {
    $args = array_slice( func_get_args(), 1 );
    $this->DELETEParams = $args;
    $this->DELETE = $cb;
    return $this;
  }

  public function exec() {
    $method = $this->request->method;
    if ( is_callable( $this->$method ) ) {
      $params = array_merge( [ $this ], $this->{$method . 'Params'} );
      call_user_func_array( $this->$method, $params );
    } else {
      $this->handleDefault();
    }
  }

  public function send( $statusCode = 200, $contentType = 'application/json', $content = '' ) {
    header("Content-Type: $contentType;charset=UTF-8");

    if ( isset( Response::$statusTexts[$statusCode] ) ) {
      http_response_code( $statusCode );
    }

    if ( !empty( $content ) ) {
      echo $content;
    } else {
      echo $this->response;
    }

    exit;
  }

  public function handleError( $e ) {
    $this->send( 500, 'application/json', json_encode( [ 'error' => $e ] ) );
  }

  public function abort( $statusCode = 404, $message = 'Sorry, something went wrong.' ) {
    $this->send( $statusCode, 'application/json', json_encode( [ 'message' => $message ] ) );
  }

  public function __toString() {
    return json_encode( $this );
  }

}
