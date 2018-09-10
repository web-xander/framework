<?php
namespace Webxander\Providers;

class ServicesProvider
{
    public function register()
    {
        // define some services
            return [
                'context' => \Symfony\Component\Routing\RequestContext::class,
                'listener.router' => \Symfony\Component\HttpKernel\EventListener\RouterListener::class,
                'dispatcher' => \Symfony\Component\EventDispatcher\EventDispatcher::class,
                'routes' => \Symfony\Component\Routing\RouteCollection::class,
                'matcher' => \Symfony\Component\Routing\Matcher\UrlMatcher::class,
                'whoops' => \Whoops\Run::class,
                'whoopsPretty' => \Whoops\Handler\PrettyPageHandler::class,
                'request_stack' => \Symfony\Component\HttpFoundation\RequestStack::class,
                'controllerResolver' => \Symfony\Component\HttpKernel\Controller\ControllerResolver::class,
                'argumentResolver' => \Symfony\Component\HttpKernel\Controller\ArgumentResolver::class,
                'debugbar' => \DebugBar\StandardDebugBar::class,
                'debugstack' => \Doctrine\DBAL\Logging\DebugStack::class,
            ];
            
    }
}