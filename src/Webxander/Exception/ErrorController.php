<?php 

namespace Webxander\Exception;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Debug\Exception\FlattenException;
use Webxander\View;

class ErrorController
{
    /**
     * @param FlattenException $exception
     * @return \Webxander\Response
     */
    public function routeErrorException(FlattenException $exception )
    {
        return View::error( $exception->getStatusCode(), new Response($exception->getMessage(), $exception->getStatusCode()));
    }

}