<?php

namespace Webxander;

class View {

    protected $response;

    public function __construct($response)
    {
        $this->response = $response; 
    }

    public function viewError($e)
    {
        $this->response->sendHeaders();
        include(getAbsolutePath()."/views/errors/$e.php");
    }

    public static function make($view, $data = null)
    {
        $request = Request::createFromGlobals();

        ob_start();
		include (getAbsolutePath()."/views/$view.php");
        $response = (new Response())->setContent(ob_get_clean());

        //$response->setSharedMaxAge( 3600 );

        //$response->headers->addCacheControlDirective( 'must-revalidate' , true );

        return $response;
    }
}