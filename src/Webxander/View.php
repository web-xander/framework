<?php

namespace Webxander;

use eftec\bladeone\BladeOne;

class View {

    protected $response;

    public function __construct($response)
    {
        $this->response = $response;
    }

    public static function error($e, $response)
    {
        $views = getAbsolutePath('/views');
        $cache = getAbsolutePath('/cache');
        $blade=new BladeOne($views,$cache,BladeOne::MODE_AUTO);

        return $response->setContent($blade->run("errors.$e"));
    }

    public static function make($view, $data = null)
    {
                
        $views = getAbsolutePath('/views');
        $cache = getAbsolutePath('/cache');
        $blade=new BladeOne($views,$cache,BladeOne::MODE_AUTO);

        if($data)
            return new Response($blade->run($view,$data));
        
        return new Response($blade->run($view));
    }
}