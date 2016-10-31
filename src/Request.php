<?php

namespace Http;

class Request {
	
	/**
	 * Holds any query parameters from the request.
	 *
	 * @var string
	 */
	private $_query;
	
	/**
	 * Holds the request body.
	 *
	 * @var string
	 */
	private $_body;
	
	/**
	 * @var mixed
	 */
	private $file;
	
	/**
	 * Gets the filename of the script called by the request.
	 *
	 * @return mixed
	 */
	public function getFile()
	{
		return $this->file;
	}
	
	/**
	 * @var
	 */
	private $host;
	
	/**
	 * Gets the host from the php server superglobals
	 *
	 * @return mixed
	 */
	public function getHost()
	{
		return $this->host;
	}
	
	/**
	 * @var
	 */
	private $method;
	
	/**
	 * Gets the request method.
	 *
	 * @return mixed
	 */
	public function getMethod()
	{
		return $this->method;
	}
	
	/**
	 * @var
	 */
	private $port;
	
	/**
	 * Gets the port from the php server superglobals
	 *
	 * @return mixed
	 */
	public function getPort()
	{
		return $this->port;
	}
	
	/**
	 * @var string
	 */
	private $pathInfo;
	
	/**
	 * Gets the path info from the php server superglobals
	 *
	 * @return string
	 */
	public function getPathInfo()
	{
		return $this->pathInfo;
	}
	
	/**
	 * @var
	 */
	private $requestURI;
	
	/**
	 * Gets the request URI from the php server superglobals
	 *
	 * @return mixed
	 */
	public function getRequestURI()
	{
		return $this->requestURI;
	}
	
	/**
	 * @var
	 */
	private $scriptName;
	
	/**
	 * Gets the name of the script called from the request
	 *
	 * @return mixed
	 */
	public function getScriptName()
	{
		return $this->scriptName;
	}
	
	/**
	 * @var mixed
	 */
	private $URIComponents;
	
	/**
	 * Gets a given URI component off the parsed request URI
	 *
	 * @param $key
	 *
	 * @return null
	 */
	public function getURIComponent( $key )
	{
		return isset($this->URIComponents[ $key ]) ? $this->URIComponents[ $key ] : NULL;
	}
	
	/**
	 * Returns the array of URI components off the parsed request URI
	 *
	 * @return mixed
	 */
	public function getAllURIComponents()
	{
		return $this->URIComponents;
	}
	
	/**
	 * @var
	 */
	private $userAgent;
	
	/**
	 * Gets the user agent from the php server superglobals
	 * @return mixed
	 */
	public function getUserAgent()
	{
		return $this->userAgent;
	}
	
	/**
	 * Request constructor.
	 */
	function __construct()
	{
		
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
		
		switch ( strtolower( $this->contentType ) )
		{
			case strtolower( stristr( $this->contentType, 'application/json' ) ):
				$this->_body = json_decode( file_get_contents( 'php://input' ), TRUE );
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
		}
	}
	
	/**
	 * Gets data off the request body.
	 * Given a key, returns the value or null.
	 * Without arguments, returns the whole request body.
	 *
	 * @param string $key
	 *
	 * @return array|mixed|null|string
	 */
	public function get( $key = '' )
	{
		if ( ! is_array( $this->_body ) || empty($key) )
		{
			return isset($this->_body) ? $this->_body : NULL;
		}
		
		return isset($this->_body[ $key ]) ? $this->_body[ $key ] : NULL;
	}
	
	/**
	 * Gets data from the query parameters of the request.
	 *
	 * @param $key
	 *
	 * @return null
	 */
	public function query( $key )
	{
		return isset($this->_query[ $key ]) ? $this->_query[ $key ] : NULL;
	}
	
	/**
	 * Pluck an id from the request URI
	 * if it can be matched as an integer,
	 * else returns false
	 *
	 * @return bool|int
	 */
	public function getIdFromURI()
	{
		$matches = [];
		
		$didMatch = (bool) preg_match( "/^\/(\d+).*?/", $this->getPathInfo(), $matches );
		
		return $didMatch ? (int) $matches[1] : $didMatch;
	}
	
	/**
	 * @return string
	 */
	public function __toString()
	{
		return json_encode( $this );
	}
	
}
