<?php

namespace App\Routes;

use Symfony\Component\HttpFoundation\Request as Request;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route as RouteProvider;
//use Symfony\Component\Routing\Route;
$request = Request::createFromGlobals();

/**
 * Routes
 */
define('URL', $request->getRequestUri());
define('PARAMS', explode('/', URL));

class Route extends RouteProvider
{
	public $url = URL;
	public $params = PARAMS;
	public $closure;
	public static $methods = ['post', 'get'];

	public function __construct($method, $route, $actions = NULL)
    {	
	        if(in_array($method, self::$methods)){
	        	/*$router = new Router($arguments);
				$router->$name();*/				
				
				if(!$actions){
					die("Debe proporcionar una accion para la ruta $route");	
				} else if(is_object($actions)){
					$this->closure = $actions;					
					parent::__construct($route, [
						'_controller' => '',
						'_action' => ''
					]);

					if($this->url == $route)
						$this->runClosure();

				} else if (class_exists($actions[0])){ 
					
					parent::__construct($route, [
						'_controller' => $actions[0],
						'_action' => $actions[1]
					]);
				}				

	        }else {
	        	throw new \InvalidArgumentException("Method not found: $name.");
	        }

	    return $this;

	        //Finaliza la ejecucion de la aplicación
	        //die();

    	//}
		//else
		//	return false;
    }

    public function runClosure()
	{
	  	$this->closure->__invoke();
	}	  
}