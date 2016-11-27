<?php

namespace Http;

class Response implements \JsonSerializable {
	
	/**
	 * Holds the data that will be used in the response.
	 *
	 * @var array
	 */
	private $_data = [];
	
	/**
	 * Response constructor.
	 */
	function __construct()
	{
		# code ...
	}
	
	/**
	 * Get a value from the response given a property.
	 *
	 * @param $property
	 *
	 * @return mixed
	 */
	public function get( $property )
	{
		return isset( $this->_data[ $property ] ) ? $this->_data[ $property ] : NULL;
	}
	
	/**
	 * Set a given property on the response with the given value.
	 *
	 * @param $property
	 * @param $value
	 *
	 * @return mixed
	 */
	public function set( $property, $value )
	{
		$this->_data[ $property ] = $value;
		
		return $this;
	}
	
	/**
	 * Set an array of key value pairs on the response.
	 *
	 * @param array $assoc_array
	 *
	 * @return $this
	 */
	public function set_array( array $assoc_array )
	{
		foreach ( $assoc_array as $property => $value )
		{
			$this->set( $property, $value );
		}
		
		return $this;
	}
	
	/**
	 * Set an array of key value pairs on the response.
	 *
	 * @param array $assoc_array
	 *
	 * @return $this
	 */
	public function setAssocArray( array $assoc_array )
	{
		foreach ( $assoc_array as $property => $value )
		{
			$this->set( $property, $value );
		}
		
		return $this;
	}
	
	/**
	 * Initializes the response data with either an empty array or the array data given.
	 *
	 * @param array $data
	 *
	 * @return $this
	 */
	public function initData( array $data = [] )
	{
		$this->_data = $data;
		
		return $this;
	}
	
	/**
	 * Use to set a numerically indexed array of data on the response object.
	 * Replaces the Response's default initialized array.
	 *
	 * @param array $data
	 *
	 * @return $this
	 */
	public function setIndexedArray( array $data )
	{
		return $this->initData( $data );
	}
	
	/**
	 * Push data onto the response as an indexed array.
	 *
	 * @param $data
	 *
	 * @return $this
	 */
	public function push( $data )
	{
		array_push( $this->_data, $data );
		
		return $this;
	}
	
	/**
	 * Prepend data onto the response as an indexed array.
	 *
	 * @param $data
	 *
	 * @return $this
	 */
	public function unshift( $data )
	{
		array_unshift( $this->_data, $data );
		
		return $this;
	}
	
	/**
	 * @param      $headerName
	 * @param      $value
	 * @param bool $replacePrevious
	 */
	public static function setHeader( $headerName, $value, $replacePrevious = TRUE )
	{
		header( "{$headerName}: {$value}", $replacePrevious );
	}
	
	/**
	 * @param string $contentType
	 */
	public static function setContentType( $contentType = 'application/json' )
	{
		self::setHeader( 'Content-Type', $contentType );
	}
	
	/**
	 * Sets the Content-Type to json and charset to UTF-8
	 */
	public static function setJSONHeader()
	{
		self::setContentType( 'application/json; charset=UTF-8;' );
	}
	
	/**
	 * Sets the response header.
	 *
	 * @param      $headerName
	 * @param      $value
	 * @param bool $replacePrevious
	 *
	 * @return $this
	 */
	public function header( $headerName, $value, $replacePrevious = TRUE )
	{
		self::setHeader( $headerName, $value, $replacePrevious );
		
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function __toString()
	{
		return json_encode( $this->jsonSerialize() );
	}
	
	/**
	 * @return array
	 */
	public function jsonSerialize()
	{
		return $this->_data;
	}
	
	const HTTP_CONTINUE                                                  = 100;
	const HTTP_SWITCHING_PROTOCOLS                                       = 101;
	const HTTP_PROCESSING                                                = 102;
	const HTTP_OK                                                        = 200;
	const HTTP_CREATED                                                   = 201;
	const HTTP_ACCEPTED                                                  = 202;
	const HTTP_NON_AUTHORITATIVE_INFORMATION                             = 203;
	const HTTP_NO_CONTENT                                                = 204;
	const HTTP_RESET_CONTENT                                             = 205;
	const HTTP_PARTIAL_CONTENT                                           = 206;
	const HTTP_MULTI_STATUS                                              = 207;
	const HTTP_ALREADY_REPORTED                                          = 208;
	const HTTP_IM_USED                                                   = 226;
	const HTTP_MULTIPLE_CHOICES                                          = 300;
	const HTTP_MOVED_PERMANENTLY                                         = 301;
	const HTTP_FOUND                                                     = 302;
	const HTTP_SEE_OTHER                                                 = 303;
	const HTTP_NOT_MODIFIED                                              = 304;
	const HTTP_USE_PROXY                                                 = 305;
	const HTTP_RESERVED                                                  = 306;
	const HTTP_TEMPORARY_REDIRECT                                        = 307;
	const HTTP_PERMANENTLY_REDIRECT                                      = 308;
	const HTTP_BAD_REQUEST                                               = 400;
	const HTTP_UNAUTHORIZED                                              = 401;
	const HTTP_PAYMENT_REQUIRED                                          = 402;
	const HTTP_FORBIDDEN                                                 = 403;
	const HTTP_NOT_FOUND                                                 = 404;
	const HTTP_METHOD_NOT_ALLOWED                                        = 405;
	const HTTP_NOT_ACCEPTABLE                                            = 406;
	const HTTP_PROXY_AUTHENTICATION_REQUIRED                             = 407;
	const HTTP_REQUEST_TIMEOUT                                           = 408;
	const HTTP_CONFLICT                                                  = 409;
	const HTTP_GONE                                                      = 410;
	const HTTP_LENGTH_REQUIRED                                           = 411;
	const HTTP_PRECONDITION_FAILED                                       = 412;
	const HTTP_REQUEST_ENTITY_TOO_LARGE                                  = 413;
	const HTTP_REQUEST_URI_TOO_LONG                                      = 414;
	const HTTP_UNSUPPORTED_MEDIA_TYPE                                    = 415;
	const HTTP_REQUESTED_RANGE_NOT_SATISFIABLE                           = 416;
	const HTTP_EXPECTATION_FAILED                                        = 417;
	const HTTP_I_AM_A_TEAPOT                                             = 418;
	const HTTP_MISDIRECTED_REQUEST                                       = 421;
	const HTTP_UNPROCESSABLE_ENTITY                                      = 422;
	const HTTP_LOCKED                                                    = 423;
	const HTTP_FAILED_DEPENDENCY                                         = 424;
	const HTTP_RESERVED_FOR_WEBDAV_ADVANCED_COLLECTIONS_EXPIRED_PROPOSAL = 425;
	const HTTP_UPGRADE_REQUIRED                                          = 426;
	const HTTP_PRECONDITION_REQUIRED                                     = 428;
	const HTTP_TOO_MANY_REQUESTS                                         = 429;
	const HTTP_REQUEST_HEADER_FIELDS_TOO_LARGE                           = 431;
	const HTTP_UNAVAILABLE_FOR_LEGAL_REASONS                             = 451;
	const HTTP_INTERNAL_SERVER_ERROR                                     = 500;
	const HTTP_NOT_IMPLEMENTED                                           = 501;
	const HTTP_BAD_GATEWAY                                               = 502;
	const HTTP_SERVICE_UNAVAILABLE                                       = 503;
	const HTTP_GATEWAY_TIMEOUT                                           = 504;
	const HTTP_VERSION_NOT_SUPPORTED                                     = 505;
	const HTTP_VARIANT_ALSO_NEGOTIATES_EXPERIMENTAL                      = 506;
	const HTTP_INSUFFICIENT_STORAGE                                      = 507;
	const HTTP_LOOP_DETECTED                                             = 508;
	const HTTP_NOT_EXTENDED                                              = 510;
	const HTTP_NETWORK_AUTHENTICATION_REQUIRED                           = 511;
	
	/**
	 * @var array
	 */
	public static $statusTexts = [
		100 => 'Continue',
		101 => 'Switching Protocols',
		102 => 'Processing',            // RFC2518
		200 => 'OK',
		201 => 'Created',
		202 => 'Accepted',
		203 => 'Non-Authoritative Information',
		204 => 'No Content',
		205 => 'Reset Content',
		206 => 'Partial Content',
		207 => 'Multi-Status',          // RFC4918
		208 => 'Already Reported',      // RFC5842
		226 => 'IM Used',               // RFC3229
		300 => 'Multiple Choices',
		301 => 'Moved Permanently',
		302 => 'Found',
		303 => 'See Other',
		304 => 'Not Modified',
		305 => 'Use Proxy',
		307 => 'Temporary Redirect',
		308 => 'Permanent Redirect',    // RFC7238
		400 => 'Bad Request',
		401 => 'Unauthorized',
		402 => 'Payment Required',
		403 => 'Forbidden',
		404 => 'Not Found',
		405 => 'Method Not Allowed',
		406 => 'Not Acceptable',
		407 => 'Proxy Authentication Required',
		408 => 'Request Timeout',
		409 => 'Conflict',
		410 => 'Gone',
		411 => 'Length Required',
		412 => 'Precondition Failed',
		413 => 'Payload Too Large',
		414 => 'URI Too Long',
		415 => 'Unsupported Media Type',
		416 => 'Range Not Satisfiable',
		417 => 'Expectation Failed',
		418 => 'I\'m a teapot',                                               // RFC2324
		421 => 'Misdirected Request',                                         // RFC7540
		422 => 'Unprocessable Entity',                                        // RFC4918
		423 => 'Locked',                                                      // RFC4918
		424 => 'Failed Dependency',                                           // RFC4918
		425 => 'Reserved for WebDAV advanced collections expired proposal',   // RFC2817
		426 => 'Upgrade Required',                                            // RFC2817
		428 => 'Precondition Required',                                       // RFC6585
		429 => 'Too Many Requests',                                           // RFC6585
		431 => 'Request Header Fields Too Large',                             // RFC6585
		451 => 'Unavailable For Legal Reasons',                               // RFC7725
		500 => 'Internal Server Error',
		501 => 'Not Implemented',
		502 => 'Bad Gateway',
		503 => 'Service Unavailable',
		504 => 'Gateway Timeout',
		505 => 'HTTP Version Not Supported',
		506 => 'Variant Also Negotiates (Experimental)',                      // RFC2295
		507 => 'Insufficient Storage',                                        // RFC4918
		508 => 'Loop Detected',                                               // RFC5842
		510 => 'Not Extended',                                                // RFC2774
		511 => 'Network Authentication Required',                             // RFC6585
	];
	
} # end class
