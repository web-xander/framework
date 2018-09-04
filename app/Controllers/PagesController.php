<?php

namespace App\Controllers;

/**
 * PageController
 */
class PagesController extends Controller
{
	public function index()
	{
		$name = "User";
		$surname = "Test";
		return view('index', compact('name','surname'));
	}

	public function welcome()
		{
			$name = "Alejandro";
			$surname = "Test";
			return view('index', compact('name','surname'));
		}	
}