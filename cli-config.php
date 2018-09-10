<?php
use Doctrine\ORM\Tools\Console\ConsoleRunner;

require __DIR__.'/vendor/autoload.php';

// replace with file to your own project bootstrap
require_once __DIR__ . '/bootstrap/app.php';

// replace with mechanism to retrieve EntityManager in your app
use Webxander\Database\Connection;

Connection::setEntityManager();

$entityManager = Connection::getEntityManager();;

return ConsoleRunner::createHelperSet($entityManager);