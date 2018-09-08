<?php

namespace Webxander\Dispatcher;

use Symfony\Component\HttpKernel\EventListener\ExceptionListener;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\DependencyInjection\Reference;

class Dispatcher 
{

    public function register($container, $routes)
    {
        $listener = new ExceptionListener(
            'Webxander\Exception\ErrorController::exception'
        );

        $container->getDefinition( 'matcher' )
		->setArguments( array( $routes , new Reference ( 'context' )));
        
        $container->getDefinition( 'listener.router' )
			->setArguments( array ( new Reference ( 'matcher' ), new Reference ( 'request_stack' )));
        
        $container->register('dispatcher', EventDispatcher::class)
            ->addMethodCall( 'addSubscriber' , array ( 
                $listener) )
                -> addMethodCall ( 'addSubscriber' , array ( 
                    new Reference ( 'listener.router' ) ) )
                -> addMethodCall ( 'addSubscriber' , array (
                new \Symfony\Component\HttpKernel\EventListener\ResponseListener( 'UTF-8' ) ))
                -> addMethodCall ( 'addSubscriber' , array (
                new \App\Listeners\StringResponseListener() ) );
        
        return $container->get('dispatcher');
    }
}