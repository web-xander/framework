<?php

namespace Webxander\Routing;

use Webxander\Request;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route as RouteProvider;
//use Symfony\Component\Routing\Route;
$request = Request::createFromGlobals();

/**
 * Routes
 */

class Route extends RouteProvider
{
	public static $methods = ['post', 'get'];

	public function __construct($method, $route, $actions = NULL)
    {	
	        if(in_array($method, self::$methods)){
	        	/*$router = new Router($arguments);
				$router->$name();*/				
				
				if(!$actions){
					die("Debe proporcionar una accion para la ruta $route");	
				} else if(is_object($actions)){
										
					parent::__construct($route, [
						'_controller' => $actions,
						
					]);					

				} else{ 
					//die($actions[0]);
					$namespace = "\\App\\Controllers\\";
					parent::__construct($route, [
						'_controller' => $namespace.$actions[0],
						
					]);
				}				

	        }else {
	        	throw new \InvalidArgumentException("Method not found: $name.");
	        }

	    return $this;

    }  
}