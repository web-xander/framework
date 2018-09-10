<?php

namespace App\Listeners;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Webxander\Response;

class StringResponseListener implements EventSubscriberInterface
{
    public function onView(GetResponseForControllerResultEvent $event)
    {
        $response = $event->getControllerResult();
        
        if ( is_string( $response )) {
            
            $event->setResponse( new Response( $response ));
        }
        if ( is_object( $response )) {
            $event->setResponse( new Response( $response ));
        }
    }

    public static function getSubscribedEvents()
    {
        //dd("estoy aqui");
        return array( 'kernel.view' => 'onView' );
    }
}