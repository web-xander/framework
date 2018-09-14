<?php

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| our application. We just need to utilize it! We'll simply require it
| into the script here so that we don't have to worry about manual
| loading any of our classes later on. It feels great to relax.
|
*/

require __DIR__.'/../vendor/autoload.php';

ini_set( 'display_errors' , 1 );
error_reporting( - 1 );

// replace with file to your own project bootstrap
require_once __DIR__ . '/../bootstrap/app.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|-------------------------------------------------------------------
*/

$application = new \Webxander\Application();

$response = $application->handle(
    $request = \Webxander\Request::capture()
);

$response->send();

$application->terminate( $request , $response );