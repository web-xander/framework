<?php

/**
 * View Function
 * @param $view; Name of View
 * @param $data; Data passing to View
 */
function view($view, $data = null)
{
	return \Webxander\View::make($view, $data);			
}

function getAbsolutePath()
{
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);

	$root = str_replace("public", "", $root);

	return $root;
}