<?php

namespace App\Routes;

use Symfony\Component\HttpFoundation\Request as Request;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
//use Symfony\Component\Routing\Route;
$request = Request::createFromGlobals();

/**
 * Routes
 */
define('URL', $request->getRequestUri());
define('PARAMS', explode('/', URL));

class Route
{
	public static $url = URL;
	public static $params = PARAMS;
	public static $validRoutes = array();
	public static $methods = ['post', 'get'];

	public static function __callStatic($name, $arguments)
    {	
    	self::$validRoutes[] = $arguments[0];
    	//if($arguments[0] == self::$url){
	        if(in_array($name, self::$methods)){
	        	$router = new Router($arguments);
	        	$router->$name();

	        }else {
	        	throw new \InvalidArgumentException("Method not found: $name.");
	        }

	    return $router;

	        //Finaliza la ejecucion de la aplicación
	        //die();

    	//}
		//else
		//	return false;
    }

    public function name($name = null)
	{
	  	# code...
	}	  
}