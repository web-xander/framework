<?php

namespace Webxander\Common\Traits;


use Webxander\Container;

trait Singleton
{
    private $singleton = array();

    /**
     * @param $className
     * @return mixed
     */
    public function singleton($className)
    {
        if (!isset($this->singleton[$className]))
            $this->singleton[$className] = Container::getClass($className);
        return $this->singleton[$className];
    }
}