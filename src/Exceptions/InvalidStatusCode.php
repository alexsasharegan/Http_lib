<?php

namespace Http\Exceptions;

/**
 * Class InvalidStatusCode
 * @package Http\Exceptions
 */
class InvalidStatusCode extends \Exception implements \JsonSerializable {
    
    protected $statusCode;
    
    /**
     * InvalidStatusCode constructor.
     *
     * @param int             $statusCode
     * @param int             $code
     * @param \Exception|NULL $previous
     */
    public function __construct( $statusCode, $code = 0, \Exception $previous = NULL )
    {
        $this->setStatusCode( $statusCode );
        $message = "Invalid HTTP status code. Status code provided: {$statusCode}";
        parent::__construct( $message, $code, $previous );
    }
    
    /**
     * @return string
     */
    public function __toString()
    {
        return __CLASS__ . ". [status code: \"{$this->statusCode}\"] {$this->message}\n";
    }
    
    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'type'       => __CLASS__,
            'message'    => $this->message,
            'statusCode' => $this->statusCode,
        ];
    }
    
    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }
    
    /**
     * @param $statusCode
     *
     * @return $this
     */
    public function setStatusCode( $statusCode )
    {
        $this->statusCode = $statusCode;
        
        return $this;
    }
}
