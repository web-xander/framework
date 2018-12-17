<?php

namespace Webxander\Dispatcher;

use Symfony\Component\HttpKernel\EventListener\ExceptionListener;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\DependencyInjection\Reference;
use Webxander\Container;

class Dispatcher 
{

    public function register($routes)
    {
        $listener = new ExceptionListener(
            'Webxander\Exception\ErrorController::exception'
        );

        Container::getDefinitionClass( 'matcher' )
		    ->setArguments( array( $routes , new Reference ( 'context' )));
        
        Container::getDefinitionClass( 'listener.router' )
			->setArguments( array ( new Reference ( 'matcher' ), new Reference ( 'request_stack' )));
        
        Container::registerClass('dispatcher', EventDispatcher::class)
            ->addMethodCall( 'addSubscriber' , array ( 
                $listener) )
            ->addMethodCall ( 'addSubscriber' , array (
                new Reference ( 'listener.router' ) ) )
            ->addMethodCall ( 'addSubscriber' , array (
                new \Symfony\Component\HttpKernel\EventListener\ResponseListener( 'UTF-8' ) ))
            ->addMethodCall ( 'addSubscriber' , array (
                new \App\Listeners\StringResponseListener() ) )
            ->addMethodCall ( 'addSubscriber' , array (
                 new \App\Listeners\DebugBarListener() ) );
        
        return Container::getClass('dispatcher');
    }
}