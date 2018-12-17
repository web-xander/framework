<?php

function app()
{
    return \Webxander\Container::getInstance();
}

/**
 * View Function
 * @param $view; Name of View
 * @param $data; Data passing to View
 *
 * @return \Webxander\Response
 */
function view($view, $data = null)
{
	return \Webxander\View::make($view, $data);			
}


/**
 * Get Absolute Path of Root Project
 * @param $url
 * @return string
 */
function getAbsolutePath($url)
{
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);

	$root = str_replace("public", "", $root);

	return $root . $url;
}


/**
 * Encrypt password use CRYPT_BLOWFISH algorithm
 * @param $psw; Password to encrypt
 * @return bool|string
 */
function bcrypt($psw)
{
	return password_hash($psw, PASSWORD_BCRYPT);
}