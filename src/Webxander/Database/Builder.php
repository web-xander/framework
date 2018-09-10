<?php

namespace Webxander\Database;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

/**
 * Query Builder
 */
class Builder
{
    protected $entityManager;

    protected $dbParams;

    protected $queryBuilder;

    public function __construct(){
        
        $this->entityManager = Connection::getEntityManager();
        
        $this->queryBuilder = Connection::getEntityManager()->createQueryBuilder();
        
    }

    public function all($model)
    {
        return $this->entityManager->getRepository($model)->findAll();
        
        //$query = $this->queryBuilder->getQuery();
        //$result = $query->getResult();        
    }
}