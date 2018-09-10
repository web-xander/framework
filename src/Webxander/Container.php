<?php

namespace Webxander;

use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class Container extends ContainerBuilder
{
    protected static $container;

    public static function setup()
    {
        self::$container = new Container;
    }

    public static function registerClass($key, $item)
    {
        return self::$container->register($key, $item);
    }

    public static function getClass($class)
    {
        return self::$container->get($class);
    }

    public static function getDefinitionClass($class)
    {
        return self::$container->getDefinition($class);
    }
}