<?php

namespace Webxander\Database;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class Connection {

    protected static $entityManager;

    public static function setEntityManager()
    {
        $dbParams = array(
            'host' => $_ENV['DB_HOST'],
            'port' => $_ENV['DB_PORT'],
            'dbname' => $_ENV['DB_DATABASE'],
            'user' => $_ENV['DB_USERNAME'],
            'password' => $_ENV['DB_PASSWORD'],
            'driver' => $_ENV['DB_DRIVER'],
            'charset' => $_ENV['DB_CHARSET']
        );  
    
        $config = Setup::createAnnotationMetadataConfiguration(
            array($_ENV['ENTITY_DIR']),
            $_ENV['DEBUG'],
            ini_get('sys_temp_dir'),
            null,
            false
        );
    
        $config->setAutoGenerateProxyClasses(true);
        if ($_ENV['DEBUG']){
            $config->setSQLLogger(new \Doctrine\DBAL\Logging\DebugStack());
        }
    
        self::$entityManager = EntityManager::create($dbParams, $config);
    }

    public static function getEntityManager()
    {
        return self::$entityManager;
    }

}