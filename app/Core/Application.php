<?php

namespace App\Core;

use Symfony\Component\HttpFoundation\Request as Request;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use App\Routes\Router;
use App\Routes\Route;


class Application {

	protected $routes;

	public function __construct()
	{
		//include files
		$routes = new RouteCollection ();
		$this->routes = require('../app/Routes/web.php');

	}

	public function run(Request $request)
	{
		
		$route = new Router($this->routes);
		$route->run($request);
		
	}
}