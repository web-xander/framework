<?php

namespace Webxander\Routing;

use Webxander\Response;
use Webxander\Container;
use Webxander\ResponseEvent;

class Router
{
	protected $url;

	protected $controller;

	protected $closure;

	protected $name;

	protected $routes;

	protected $matcher;

	protected $dispatcher;

    protected $arguments;

    protected $request;

    /**
     * Router constructor.
     * @param $request
     * @param $routes
     * @param $dispatcher
     * @param $controller
     * @param $arguments
     */
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

    /**
     * @return mixed|Response
     */
    public function run(){
		
	    $response = $this->handle();

		// dispatch a response event
        $this->dispatcher->dispatch( 'response' , new ResponseEvent( $response , $this->request ));

		return $response;

	}


    /**
     * Llama a un metodo de clase si existe.
     * @return mixed|Response
     */
    public function handle()
	{
		if(is_object($this->controller)){
			return $this->runClosure();
		}else{			
			
			return $this->runController();
		} 
	}

    /**
     * @return mixed
     */
    public function getRoutes()
    {
        return $this->routes;
	}

    /**
     * @return mixed|Response
     */
    public function runClosure()
	{
		  $response = call_user_func($this->controller);
		  if($response instanceof Response)
		      return $response;
		  return new Response($response);
	}

    /**
     * @return mixed|Response
     */
    public function runController()
	{
			$response = call_user_func_array( $this->controller, $this->arguments);
            if($response instanceof Response)
				return $response;
			return new Response($response);
	}	

}