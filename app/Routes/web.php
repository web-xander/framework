<?php

namespace App\Routes;

use Symfony\Component\HttpFoundation\Response as Response;
use App\Controllers\PagesController;
use Symfony\Component\Routing\RouteCollection;
/**
 * Routes
 */

$routes->add('home', new Route('get', '/', function (){
    echo "Hello!";
}));

$routes->add('pages', 
    new Route('get', '/pages', [
    PagesController::class,'index'
]));

$routes->add('blog', 
    new Route('get', '/blog', [
    PagesController::class,'welcome'
]));

$routes->add('welcome', 
    new Route('get', '/welcome', function (){
	    echo "Welcome to WebXander";
}));

return $routes;

//Route::get('/',PagesController::class,'index');

/*Route::get('/',function(){
	
	$response = new Response();

	echo $response->setContent( 'Hello world!' );
}, ['name' => 'home']);

Route::get('/pages',[PagesController::class,'index'], ['name' => 'pages']);

Route::get('/welcome',function (){

	echo "Welcome to WebXander";

}, ['name' => 'users']);
*/
