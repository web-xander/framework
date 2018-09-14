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
	
	public function create($model, $data)
	{
        $newModel = new $model();

        foreach($data[0] as $key => $item){
            $newModel->$key = $item;
        }
        //die();
        

        $this->entityManager->persist($newModel);
        $this->entityManager->flush();
        
        return $newModel;
	}

    public function all($model)
    {
        return $this->entityManager->getRepository($model)->findAll();
    }
}