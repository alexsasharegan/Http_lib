<?php

namespace Http;

class JsonResponse implements Responder {

  protected $body;
  protected $status;

  /**
   * @param mixed $data
   * @param int   $status
   */
  public function __construct($data = '', $status = Status::HTTP_OK) {
    $this->body = $data;
    $this->status = (int) $status;
  }

  /**
   * @return int
   */
  public function get_status() {
    return $this->status;
  }

  /**
   * @return string
   */
  public function get_content_type() {
    return 'application/json';
  }

  /**
   * @return string
   */
  public function get_body() {
    return json_encode($this->body);
  }
}
