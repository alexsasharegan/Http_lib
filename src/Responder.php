<?php

namespace Http;

interface Responder {

  /**
   * @return int
   */
  public function get_status();

  /**
   * @return string
   */
  public function get_content_type();

  /**
   * @return string
   */
  public function get_body();
}
