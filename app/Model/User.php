<?php

namespace App\Model;

use Webxander\Database\Model;
use Webxander\Common\Inflect;

class User extends Model
{
    public $firstname;

    public $password;

    public static $table = 'users';

}
