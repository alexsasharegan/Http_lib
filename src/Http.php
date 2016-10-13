<?php

namespace Http;

use Http\Exceptions\InvalidStatusCode;
use Http\Exceptions\ResponseAlreadySent;

class Http {
	
	private $hasSent = FALSE;
	
	/**
	 * @var
	 */
	private $beforeFunc;
	
	private $afterFunc;
	
	/**
	 * Redirect to a given URL.
	 * Exits execution.
	 *
	 * @param string $url
	 */
	public static function redirect( $url = '/' )
	{
		header( "Location: $url" );
		exit;
	}
	
	/**
	 * If given a valid status code,
	 * sets the status and return the previous status code.
	 *
	 * If not, returns the current status code.
	 *
	 * @param int $statusCode
	 *
	 * @return int
	 * @throws InvalidStatusCode
	 */
	public static function status( $statusCode = NULL )
	{
		if ( ! is_null( $statusCode ) )
		{
			if ( isset(Response::$statusTexts[ $statusCode ]) )
			{
				return http_response_code( $statusCode );
			}
			else
			{
				throw new InvalidStatusCode( $statusCode, 1 );
			}
		}
		
		else
		{
			return http_response_code();
		}
	}
	
	/**
	 * Sets the header response header.
	 * - Convenience method proxy for the Response class
	 *
	 * @param      $headerName
	 * @param      $value
	 * @param bool $replacePrevious
	 *
	 * @return void
	 */
	public function header( $headerName, $value, $replacePrevious = TRUE )
	{
		$this->response->header( $headerName, $value, $replacePrevious );
	}
	
	/**
	 * Http constructor.
	 *
	 * @param string $timezone
	 */
	function __construct( $timezone = "America/Phoenix" )
	{
		date_default_timezone_set( $timezone );
		set_exception_handler( [ $this, 'handleError' ] );
		set_error_handler( function ( $errno, $errstr, $errfile = '', $errline = '' )
		{
			$this->response->set_array( [
				'error' => [
					'level'   => $errno,
					'message' => $errstr,
					'file'    => $errfile,
					'line'    => $errline,
				],
			] );
		} );
		
		$this->request  = new Request;
		$this->response = new Response;
	}
	
	/**
	 *
	 */
	private function handleDefault()
	{
		$this->response->set_array( [
			'error' => [
				'message' => "No route has been defined for this request method.",
			],
		] );
		$this->send( Response::HTTP_METHOD_NOT_ALLOWED );
	}
	
	/**
	 * Defines a GET callback
	 *
	 * @param callable $cb
	 *
	 * @return Http $this
	 */
	public function get( callable $cb )
	{
		$args            = array_slice( func_get_args(), 1 );
		$this->GETParams = $args;
		$this->GET       = $cb;
		
		return $this;
	}
	
	/**
	 * Defines a POST callback
	 *
	 * @param callable $cb
	 *
	 * @return Http $this
	 */
	public function post( callable $cb )
	{
		$args             = array_slice( func_get_args(), 1 );
		$this->POSTParams = $args;
		$this->POST       = $cb;
		
		return $this;
	}
	
	/**
	 * Defines a PUT callback
	 *
	 * @param callable $cb
	 *
	 * @return Http $this
	 */
	public function put( callable $cb )
	{
		$args            = array_slice( func_get_args(), 1 );
		$this->PUTParams = $args;
		$this->PUT       = $cb;
		
		return $this;
	}
	
	/**
	 * Defines a PATCH callback
	 *
	 * @param callable $cb
	 *
	 * @return Http $this
	 */
	public function patch( callable $cb )
	{
		$args              = array_slice( func_get_args(), 1 );
		$this->PATCHParams = $args;
		$this->PATCH       = $cb;
		
		return $this;
	}
	
	/**
	 * Defines a DELETE callback
	 *
	 * @param callable $cb
	 *
	 * @return Http $this
	 */
	public function delete( callable $cb )
	{
		$args               = array_slice( func_get_args(), 1 );
		$this->DELETEParams = $args;
		$this->DELETE       = $cb;
		
		return $this;
	}
	
	/**
	 * Defines the global exception handler
	 *
	 * @param callable $cb
	 *
	 * @return Http $this
	 */
	public function error( callable $cb )
	{
		set_exception_handler( $cb );
		
		return $this;
	}
	
	
	/**
	 * Set a callback to be run before any route callback is executed.
	 * Called with the Http instance as it's one argument.
	 *
	 * @param \Closure $f
	 *
	 * @return $this
	 */
	public function before( \Closure $f )
	{
		$this->beforeFunc = $f;
		
		return $this;
	}
	
	/**
	 * Call the before middleware
	 */
	private function callBefore()
	{
		if ( ! $this->beforeFunc instanceof \Closure )
		{
			$this->beforeFunc = function () { };
		}
		
		call_user_func( $this->beforeFunc, $this );
	}
	
	/**
	 * Set a callback to be run after any route callback is executed.
	 * Called with the Http instance as it's one argument.
	 *
	 * @param \Closure $f
	 *
	 * @return $this
	 */
	public function after( \Closure $f )
	{
		$this->afterFunc = $f;
		
		return $this;
	}
	
	/**
	 * Call the after middleware
	 */
	private function callAfter()
	{
		if ( ! is_callable( $this->afterFunc ) )
		{
			$this->afterFunc = function () { };
		}
		
		call_user_func( $this->afterFunc, $this );
	}
	
	/**
	 * Runs the route
	 *
	 * @return void
	 */
	public function exec()
	{
		$this->callBefore();
		
		$method = $this->request->getMethod();
		
		if ( is_callable( $this->$method ) )
		{
			$params = array_merge( [ $this ], $this->{$method . 'Params'} );
			call_user_func_array( $this->$method, $params );
		}
		else
		{
			$this->handleDefault();
		}
		
		$this->callAfter();
		
		exit;
	}
	
	/**
	 * Sends a response and exits script execution.
	 *
	 * @param int    $statusCode
	 * @param string $contentType
	 * @param string $content
	 *
	 * @throws InvalidStatusCode
	 * @throws ResponseAlreadySent
	 */
	public function send( $statusCode = 200, $contentType = 'application/json', $content = '' )
	{
		if ( $this->hasSent )
		{
			throw new ResponseAlreadySent;
		}
		
		$this->hasSent = TRUE;
		
		header( "Content-Type: $contentType; charset=UTF-8", TRUE );
		
		self::status( $statusCode );
		
		echo ! empty($content) ? $content : $this->response;
	}
	
	/**
	 * This is really an exception handler
	 * "error" is just syntactical sugar
	 *
	 * @param \Exception $e
	 *
	 * @return void
	 */
	public function handleError( \Exception $e )
	{
		$this->send( 500, 'application/json', json_encode( [ 'error' => $e ] ) );
	}
	
	/**
	 * A convenience method to abort the route
	 * and send a response with the given status & message
	 *
	 * @param int    $statusCode
	 * @param string $message
	 *
	 * @return void
	 */
	public function abort( $statusCode = 404, $message = 'Sorry, something went wrong.' )
	{
		$this->send( $statusCode, 'application/json', json_encode( [ 'message' => $message ] ) );
	}
	
	/**
	 * @return string
	 */
	public function __toString()
	{
		return json_encode( $this );
	}
	
}
