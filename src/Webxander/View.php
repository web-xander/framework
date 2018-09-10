<?php

namespace Webxander;

use eftec\bladeone\BladeOne;

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
                
        $views = getAbsolutePath() . '/views';
        $cache = getAbsolutePath() . '/cache';
        $blade=new BladeOne($views,$cache,BladeOne::MODE_AUTO);

        if($data)
            return new Response($blade->run($view,$data));
        
        return new Response($blade->run($view));
    }
}