<?php

namespace App\Routes;

use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\HttpKernel;

class Router
{
	protected $url;

	protected $class;

	protected $action;

	protected $closure;

	protected $name;

	protected $routes;

	public function __construct($routes){

		$this->routes = $routes;

	}

	public function run($request){

		$context = new RequestContext('/');
		$context->fromRequest( $request );				
		$matcher = new UrlMatcher( $this->routes , $context);

		$controllerResolver = new HttpKernel\Controller\ControllerResolver();
		$argumentResolver = new HttpKernel\Controller\ArgumentResolver();

		$attributes = $matcher->match($request->getRequestUri());
		
		if(class_exists($attributes['_controller'])){
			$obj = new $attributes['_controller'];
			if(method_exists($obj, $attributes['_action'])){	
				call_user_func( array( $obj, $attributes['_action'] ));
			} else {
				throw new \InvalidArgumentException("Action not found: {$attributes['_action']}");
			}
		}
	}

	/*
	*
	* Llama a una accion desde una ruta utilizando el metodo GET
	*/
	public function get()
	{

			return self::$routes->add($this->name, new Route( $this->url , array( '_controller' => $this->class )) );


			/*if($this->closure){
				$this->closure->__invoke();

			} else if ($this->class) {
				
				call_user_func( array( new $this->class, $this->action ) );				
			}
			else if(is_string($this->params[1])) {
				echo $this->params[1];
			}
			else {	

				throw new \InvalidArgumentException("Class not found: $this->class.");
			}*/
		
	}

	public static function getRoutes()
    {
        return self::$routes;
    }

}