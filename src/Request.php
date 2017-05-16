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
    
    private $ip;
    /**
     * @var
     */
    private $host;
    /**
     * @var
     */
    private $method;
    /**
     * @var
     */
    private $port;
    /**
     * @var string
     */
    private $pathInfo;
    /**
     * @var
     */
    private $requestURI;
    /**
     * @var
     */
    private $scriptName;
    /**
     * @var mixed
     */
    private $URIComponents;
    /**
     * @var
     */
    private $userAgent;
    
    /**
     * Request constructor.
     */
    function __construct()
    {
        
        $this->contentType = isset( $_SERVER['CONTENT_TYPE'] ) ? $_SERVER['CONTENT_TYPE'] : '';
        $this->cookies = isset( $_SERVER['HTTP_COOKIE'] ) ? $_SERVER['HTTP_COOKIE'] : '';;
        
        // PHP throws a scrict-mode warning if we don't use an interim variable
        // "Strict Standards: Only variables should be passed by reference"
        $scriptNameArray = explode( '/', $_SERVER['SCRIPT_NAME'] );
        $this->file = end( $scriptNameArray );
        
        $this->host = $_SERVER['HTTP_HOST'];
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->_query = $_GET;
        $this->port = $_SERVER['SERVER_PORT'];
        $this->pathInfo = isset( $_SERVER['PATH_INFO'] ) ? $_SERVER['PATH_INFO'] : '';
        $this->requestURI = $_SERVER['REQUEST_URI'];
        $this->scriptName = $_SERVER['SCRIPT_NAME'];
        $this->URIComponents = parse_url( $_SERVER['REQUEST_URI'] );
        $this->userAgent = $_SERVER['HTTP_USER_AGENT'];
        $this->ip = $_SERVER['REMOTE_ADDR'];
        $this->headers = getallheaders();
        
        switch ( strtolower( $this->contentType ) )
        {
            case strtolower( stristr( $this->contentType, Http::MIME_APPLICATION_JSON ) ):
                $this->_body = json_decode( file_get_contents( 'php://input' ), TRUE );
                break;
            case strtolower( stristr( $this->contentType, Http::MIME_FORM_URL_ENCODED ) ):
                $this->_body = $_POST;
                break;
            case strtolower( stristr( $this->contentType, Http::MIME_TEXT_PLAIN ) ):
                $this->_body = file_get_contents( 'php://input' );
                break;
            default:
                $this->_body = @file_get_contents( 'php://input' );
                break;
        }
    }
    
    /**
     * @return mixed
     */
    public function getIp()
    {
        return $this->ip;
    }
    
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
     * Gets the host from the php server superglobals
     *
     * @return mixed
     */
    public function getHost()
    {
        return $this->host;
    }
    
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
     * Gets the port from the php server superglobals
     *
     * @return mixed
     */
    public function getPort()
    {
        return $this->port;
    }
    
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
     * Gets the name of the script called from the request
     *
     * @return mixed
     */
    public function getScriptName()
    {
        return $this->scriptName;
    }
    
    /**
     * Gets a given URI component off the parsed request URI
     *
     * @param $key
     *
     * @return null
     */
    public function getURIComponent( $key )
    {
        return isset( $this->URIComponents[ $key ] ) ? $this->URIComponents[ $key ] : NULL;
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
     * Gets the user agent from the php server superglobals
     * @return mixed
     */
    public function getUserAgent()
    {
        return $this->userAgent;
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
    public function getParam( $key = '' )
    {
        return $this->get( $key );
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
        if ( ! is_array( $this->_body ) || empty( $key ) )
        {
            return isset( $this->_body ) ? $this->_body : NULL;
        }
        
        return isset( $this->_body[ $key ] ) ? $this->_body[ $key ] : NULL;
    }
    
    /**
     * Returns the whole request body.
     *
     * @return array|mixed|null|string
     */
    public function getAllParams()
    {
        return isset( $this->_body ) ? $this->_body : NULL;
    }
    
    /**
     * Gets data from the query parameters of the request.
     *
     * @param $key
     *
     * @return mixed|null
     */
    public function getQueryParam( $key = '' )
    {
        return $this->query( $key );
    }
    
    /**
     * Gets data from the query parameters of the request.
     *
     * @param $key
     *
     * @return mixed|null
     */
    public function query( $key = '' )
    {
        if ( empty( $key ) )
        {
            return isset( $this->_query ) ? $this->_query : NULL;
        }
        
        return isset( $this->_query[ $key ] ) ? $this->_query[ $key ] : NULL;
    }
    
    /**
     * Gets data from the query parameters of the request.
     *
     * @return mixed|null
     */
    public function getAllQueryParams()
    {
        return $this->_query;
    }
    
    public function server( $key = '' )
    {
        if ( empty( $key ) )
        {
            return $_SERVER;
        }
        
        return isset( $_SERVER[ $key ] ) ? $_SERVER[ $key ] : NULL;
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
     * Gets the path info from the php server superglobals
     *
     * @return string
     */
    public function getPathInfo()
    {
        return $this->pathInfo;
    }
    
    /**
     * @return string
     */
    public function __toString()
    {
        return json_encode( $this );
    }
    
}
