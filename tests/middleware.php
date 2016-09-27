<?php
/**
 * Created by PhpStorm.
 * User: Sasha
 * Date: 9/27/16
 * Time: 7:33 AM
 */

use Http\Http;
use Http\Response;

require_once __DIR__ . "/../vendor/autoload.php";

$http = new Http;

$http->before( function ( Http $http )
{
	echo "This came before the route.\n";
} );

$http->after( function ( Http $http )
{
	//echo "\nThis came after the route.\n";
	$http->response->set( 'afterMessage', "This came after the route." );
	$http->send();
} );

$http->get( function ( Http $http )
{
	$res = $http->response;
	$res->set( 'message', 'Main route.' );
	
	$http->send( Response::HTTP_OK );
} );

$http->exec();