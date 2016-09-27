<?php

namespace Http\Exceptions;

/**
 * Class ResponseAlreadySent
 * @package Http\Exceptions
 */
class ResponseAlreadySent extends \Exception implements \JsonSerializable {
	
	/**
	 * ResponseAlreadySent constructor.
	 *
	 * @param string         $message
	 * @param int            $code
	 * @param Exception|NULL $previous
	 */
	public function __construct( $message = '', $code = 0, Exception $previous = NULL )
	{
		if ( empty($message) )
		{
			$message = "Response already sent. Cannot call send twice.";
		}
		parent::__construct( $message, $code, $previous );
	}
	
	/**
	 * @return string
	 */
	public function __toString()
	{
		return __CLASS__ . ". [code: {$this->code}] {$this->message}\n";
	}
	
	/**
	 * @return array
	 */
	public function jsonSerialize()
	{
		return [
			'type'    => __CLASS__,
			'message' => $this->message,
			'code'    => $this->code,
		];
	}
}
