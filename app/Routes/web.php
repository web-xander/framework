<?php

namespace App\Routes;

use Webxander\Routing\Route;
/**
 * Routes
 */

$routes->add('home', new Route('get', '/', function (){
    
	return view('welcome');
}));

$routes->add('users.create', 
    new Route('post', '/users/create', [
    'PagesController::create'
]));

$routes->add('pages', 
    new Route('get', '/pages', [
    'PagesController::index'
]));

$routes->add('blog', 
    new Route('get', '/blog', [
    'PagesController::welcome'
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
