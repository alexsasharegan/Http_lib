<?php

namespace Http;

class Request {
	
	private $_body,
		$_query;
	
	/**
	 * Request constructor.
	 */
	function __construct() {
		
		$this->contentType = isset($_SERVER['CONTENT_TYPE']) ? $_SERVER['CONTENT_TYPE'] : '';
		$this->cookies     = isset($_SERVER['HTTP_COOKIE']) ? $_SERVER['HTTP_COOKIE'] : '';;
		
		// PHP throws a scrict-mode warning if we don't use an interim variable
		// "Strict Standards: Only variables should be passed by reference"
		$scriptNameArray = explode( '/', $_SERVER['SCRIPT_NAME'] );
		$this->file      = end( $scriptNameArray );
		
		$this->host          = $_SERVER['HTTP_HOST'];
		$this->method        = $_SERVER['REQUEST_METHOD'];
		$this->_query        = $_GET;
		$this->port          = $_SERVER['SERVER_PORT'];
		$this->pathInfo      = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
		$this->requestURI    = $_SERVER['REQUEST_URI'];
		$this->scriptName    = $_SERVER['SCRIPT_NAME'];
		$this->URIComponents = parse_url( $_SERVER['REQUEST_URI'] );
		$this->userAgent     = $_SERVER['HTTP_USER_AGENT'];
		
		switch ( strtolower( $this->contentType ) ) {
			case strtolower( stristr( $this->contentType, 'application/json' ) ):
				$this->_body = json_decode( file_get_contents( 'php://input' ), true );
				break;
			case strtolower( stristr( $this->contentType, 'application/x-www-form-urlencoded' ) ):
				$this->_body = $_POST;
				break;
			case strtolower( stristr( $this->contentType, 'text/plain' ) ):
				$this->_body = file_get_contents( 'php://input' );
				break;
			default:
				$this->_body = @file_get_contents( 'php://input' );
				break;
		} # end switch
		
	} # end constructor
	
	/**
	 * @param string $key
	 * @return array|mixed|null|string
	 */
	public function get( $key = '' ) {
		if ( !is_array( $this->_body ) || empty($key) ) {
			return isset($this->_body) ? $this->_body : null;
		}
		return isset($this->_body[$key]) ? $this->_body[$key] : null;
	}
	
	/**
	 * @param $key
	 * @return null
	 */
	public function query( $key ) {
		return isset($this->_query[$key]) ? $this->_query[$key] : null;
	}
	
	/**
	 * @return string
	 */
	public function __toString() {
		return json_encode( $this );
	}
	
} # end class
