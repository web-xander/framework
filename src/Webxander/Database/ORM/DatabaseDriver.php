<?php

namespace Webxander\Database\ORM;

use Doctrine\Common\Inflector\Inflector;
use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use Doctrine\ORM\Mapping\Driver\DatabaseDriver as DoctrineDatabaseDriver;

class DatabaseDriver extends DoctrineDatabaseDriver
{
    /**
     * {@inheritDoc}
     */
    public function loadMetadataForClass($className, ClassMetadata $metadata)
    {   
        if((isset($className::$table)) && ($className::$table)){
            $tableName = $className::$table;     
        } else {
        
            $tableName = Inflector::pluralize(str_replace("App\Model\\","", $className));
            $tableName = Inflector::tableize($tableName);
        }
        
        $this->setClassNameForTable($tableName, $className);

        parent::loadMetadataForClass($className, $metadata);
    }
}