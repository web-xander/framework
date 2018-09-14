<?php

namespace App\Model;

use Webxander\Database\Model;
use Webxander\Common\Inflect;
use Doctrine\ORM\Mapping\ClassMetadata;

class User extends Model
{
    public $firstname;

    public $password;

    public static $table = 'users';

}
