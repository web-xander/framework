<?php 

namespace App\Listeners;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Webxander\ResponseEvent;
use DebugBar\StandardDebugBar;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class DebugBarListener implements EventSubscriberInterface
{
    public function onResponse(ResponseEvent $event)
    {
        $response = $event->getResponse();

        if ($response->isRedirection()
            || ($response->headers->has('Content-Type') && false === strpos($response->headers->get('Content-Type'), 'html'))
            || 'html' !== $event->getRequest()->getRequestFormat()
        ) {
            return;
        }

        //Create a DebugBar with variables passes to View        
        $debugbar = \Webxander\Container::getClass( 'debugbar' );        
        $debugbarRenderer = $debugbar->getJavascriptRenderer()->setBaseUrl('/Resources');

        $entityManager = \Webxander\Database\Connection::getEntityManager();

        $debugStack = $entityManager->getConnection()->getConfiguration()->getSqlLogger();

        $debugbar->addCollector(new \DebugBar\Bridge\DoctrineCollector($debugStack));

        $renderCss = $debugbarRenderer->renderHead();
        
        $renderJs = $debugbarRenderer->render();

               
        $response->setContent($renderCss.$response->getContent().$renderJs);
    }

    public static function getSubscribedEvents()
    {
        return array('response' => 'onResponse');
    }
}