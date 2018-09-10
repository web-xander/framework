<?php

namespace Webxander;

use Symfony\Component\HttpKernel\HttpKernel;
use Webxander\Routing\Router;
use Webxander\Routing\Route;
use Webxander\Providers\ServicesProvider;
use Webxander\Dispatcher\Dispatcher;
use Symfony\Component\DependencyInjection;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class Application extends HttpKernel 
{

	protected $routes;

	protected $dispatcher;

	protected $controller;

	protected $arguments;

	public $request;

	public $response;

	protected $controllerResolver;

	protected $requestStack;

	protected $argumentResolver;

	public function __construct()
	{

		$this->request = Request::capture();

		//$this->container = new Container();
		Container::setup();
		//dd($this->container);

		$this->addServices(ServicesProvider::class);

		$this->whoops();

		$this->setRoutes();

		$this->setDispatcherEvents();

		$this->callRouteManager();

		parent::__construct ( $this->dispatcher , $this->controllerResolver , $this->requestStack , $this->argumentResolver );

	}

	public function handle(
		\Symfony\Component\HttpFoundation\Request $request,
		$type = self::MASTER_REQUEST,
        $catch = true
		)
	{
		return $this->run();
	}

	public function terminate(\Symfony\Component\HttpFoundation\Request $request , \Symfony\Component\HttpFoundation\Response $response)
	{
		parent::terminate($request, $response);
	}

	public function run()
	{

		//Route::controller('index', 'PagesController');

		$route = new Router($this->request, $this->routes, $this->dispatcher, $this->controller, $this->arguments);
		
		if($this->response == null){
			$this->response = $route->run();
			
		}

		return $this->response;
		
	}

	/**
     * Get application controller
     */
	public function getController()
	{
		return $this->controller;
	}

	/**
     * Get application arguments
     */
	public function getArguments()
	{
		return $this->arguments;
	}

	/**
     * Register services to container
     */
	public function addServices($provider)
	{
		$services = new $provider;
		$services = $services->register();
		foreach($services as $key => $item)
			Container::registerClass( $key , $item );
	}

	/**
     * Setting whoops config
     */
	public function whoops()
	{
		$whoops = Container::getClass('whoops');
		$whoops->pushHandler(Container::getClass('whoopsPretty'));
		$whoops->register();
	}

	/**
     * Setting application routes
     */
	public function setRoutes()
	{
		$routes = Container::getClass( 'routes' );	

		$this->routes = require(getAbsolutePath()."/app/Routes/web.php");
	}

	/**
     * Get application routes
     */
	public function getRoutes()
	{
		return $this->routes;
	}

	/**
     * Setting application dispatcher events
     */
	public function setDispatcherEvents()
	{
		$this->dispatcher = (new Dispatcher())->register($this->routes);
	}

	/**
     * Get application dispatcher events
     */
	public function getDispatcherEvents()
	{
		return $this->dispatcher;
	}

	/**
     * Manage Routes
     */
	public function callRouteManager()
	{
		$context = Container::getClass( 'context' );
		$context->fromRequest( $this->request );
		$matcher = Container::getClass( 'matcher' );

		
		$this->controllerResolver = Container::getClass('controllerResolver');
		$this->argumentResolver = Container::getClass('argumentResolver');
		$this->requestStack = Container::getClass('request_stack');
		
		try{
			$this->request->attributes->add($matcher->match( $this->request->getPathInfo()));
			
			$this->controller = $this->controllerResolver->getController( $this->request );

			$this->arguments = $this->argumentResolver->getArguments( $this->request , $this->controller );
			
		} catch ( ResourceNotFoundException $exception ) {
						
			//$exception = new \RuntimeException($exception->getMessage(), 404, $exception);
			$exception = \Symfony\Component\Debug\Exception\FlattenException::create($exception, 404);
			$this->response = (new \Webxander\Exception\ErrorController())->exception($exception);
		
		} catch ( \Exception $exception ) {
			
			$this->response = new Response ( 'An error occurred' , 500 );
			
		}
	}


}