<?php

namespace Webxander\Routing;

use Webxander\Response;
use Webxander\Request;
use Webxander\Container;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Webxander\ResponseEvent;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Route;
use Symfony\Component\HttpKernel;

class Router
{
	protected $url;

	protected $controller;

	protected $closure;

	protected $name;

	protected $routes;

	protected $matcher;

	protected $dispatcher;

	public function __construct($request, $routes, $dispatcher, $controller, $arguments){

		$this->controller = $controller;

		$this->arguments = $arguments;
		
		$this->dispatcher = $dispatcher;
		
		$this->routes = $routes;

		$this->request = $request;

		$context = Container::getClass( 'context' );
		$context->fromRequest( $this->request );			
		
		$this->matcher = Container::getClass( 'matcher' );

	}

	public function run(){

		
			//$attributes = $this->matcher->match($this->request->getRequestUri());
		
			$response = $this->handle();

		// dispatch a response event
        $this->dispatcher->dispatch( 'response' , new ResponseEvent( $response , $this->request ));

		return $response;

	}

	/*
	*
	* Llama a un metodo de clase si existe.
	*/
	public function handle()
	{

		//dd($this->controller[0]);
		if(is_object($this->controller)){
			return $this->runClosure();			
		}else{			
			
			return $this->runController();
		} 
	}

	/*
	*
	* Llama a una accion desde una ruta utilizando el metodo GET
	*/
	public function get()
	{
		
	}

	public function getRoutes()
    {
        return $this->routes;
	}
	
	public function runClosure()
	{
		  call_user_func($this->controller);
		  return new Response();
	}
	
	public function runController()
	{
		
			$response = call_user_func_array( $this->controller, $this->arguments);
			if(is_string($response))
				return new Response($response);
			return $response;
		
	}	

}