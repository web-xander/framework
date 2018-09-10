<?php

namespace Webxander\Database;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

use Doctrine\ORM\Mapping as ORM;

abstract class Model
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;

    public function all()
    {
        return $this->newQuery()->all(get_called_class());
    }

    public function newQuery()
    {
        return new Builder;
    }
}