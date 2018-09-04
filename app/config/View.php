<?php

/**
 * View Function
 * @param $view; Name of View
 * @param $data; Data passing to View
 */
function view($view, $data = null)
{
	
		if (!file_exists("../views/$view.php"))
  			throw new InvalidArgumentException("View [{$view}] not found.");
		else
			require ("../views/$view.php");
	
	
}

function errors($typeNumber)
{
	if($typeNumber == 404){
		view("errors/404");
	}
}