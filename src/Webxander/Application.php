<?php

namespace Webxander;

use Symfony\Component\HttpKernel\HttpKernel;
use Webxander\Common\Traits\Singleton;
use Webxander\Routing\Router;
use Webxander\Database\Connection;
use Webxander\Providers\ServicesProvider;
use Webxander\Dispatcher\Dispatcher;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class Application extends HttpKernel
{

    use Singleton;

	protected $routes;

	protected $dispatcher;

	protected $controller;

	protected $arguments;

	public $request;

	public $response;

	protected $controllerResolver;

	protected $requestStack;

	protected $argumentResolver;

	public function __construct($request)
	{
        $this->request = $request;

        $dotenv = new \Dotenv\Dotenv(__DIR__.'//../../');
        $dotenv->load();
        $dotenv->required([
            'DB_HOST',
            'DB_DATABASE',
            'DB_USERNAME',
            'DB_PASSWORD',
            'DB_DRIVER'
        ]);

		Container::setup();

		Container::registerInstance($this);

		$this->addServices(ServicesProvider::class);

		$this->whoops();

		Connection::setEntityManager();

		$this->setRoutes();

		$this->setDispatcherEvents();

		$this->callRouteManager();

		parent::__construct ( $this->dispatcher , $this->controllerResolver , $this->requestStack , $this->argumentResolver );

	}

	public function handle(
		\Symfony\Component\HttpFoundation\Request $request = NULL,
		$type = self::MASTER_REQUEST,
        $catch = true
		)
	{

        if(!$this->response){
            if (($this->request->getMethod()) == strtoupper($this->request->attributes->get('_method')))
                return $this->run();
            else
                throw new \InvalidArgumentException("Method not allowed");
        }

        return $this->response;
	}

	public function terminate(\Symfony\Component\HttpFoundation\Request $request , \Symfony\Component\HttpFoundation\Response $response)
	{
		parent::terminate($request, $response);
	}

	public function run()
	{
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
     * @param $provider
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

		$this->routes = require(getAbsolutePath("/app/Routes/web.php"));
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
			$exception = \Symfony\Component\Debug\Exception\FlattenException::create($exception, 404);
			$this->response = (new \Webxander\Exception\ErrorController())->routeErrorException($exception);

		
		} catch ( \Exception $exception ) {
			
			$this->response = new Response ( 'An error occurred' , 500 );

			
		}
	}


}