<?php

namespace Webxander\Database;

use Webxander\Common\Inflect;

abstract class Model
{
    public static $builder;
    
    protected $id;

    protected $data = array();

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public static function __callstatic($name, $arguments)
	{
		return self::newQueryStatic()->$name(get_called_class(), $arguments);
	}
	
	public static function newQueryStatic()
	{
		return new Builder;
	}

    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    public function __get($name)
    {
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }
        //dd($name);
        $trace = debug_backtrace();
        trigger_error(
            'Propiedad indefinida mediante __get(): ' . $name .
            ' en ' . $trace[0]['file'] .
            ' en la línea ' . $trace[0]['line'],
            E_USER_NOTICE);
        return null;
    }
	
	public function __call($name, $arguments)
	{
		return $this->newQuery()->$name(get_called_class());
	}

    public function newQuery()
    {
        return new Builder;
    }
}