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


/**
 * Get Absolute Path of Root Proyect
 * 
 */
function getAbsolutePath()
{
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);

	$root = str_replace("public", "", $root);

	return $root;
}


/**
 * Encrypt password use CRYPT_BLOWFISH algorytm
 * @param $psw; Password to encrypt
 */
function bcrypt($psw)
{
	return password_hash($psw, PASSWORD_BCRYPT);
}