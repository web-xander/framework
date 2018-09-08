<?php

namespace App\Controllers;

use Webxander\Request;
/**
 * PageController
 */
class PagesController extends Controller
{
	public function index(Request $request)
	{
		$name = "User";
		$surname = "Test";
		return view('index', compact('name','surname'));
	}

	public function welcome(Request $request, $user = "Alejandro")
	{
		$name = $user;
		$surname = "Test";
		return "Hola mundo!";
		return view('index', compact('name','surname'));
	}	
}