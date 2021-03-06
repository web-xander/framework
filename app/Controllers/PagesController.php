<?php

namespace App\Controllers;

use Webxander\Request;
use App\Model\User;
/**
 * PageController
 */
class PagesController extends Controller
{
	public function index(Request $request)
	{
		$users = User::all();
		
		return view('index', compact('users'));
	}

	public function welcome(Request $request)
	{
		return view('welcome');
	}	
	
	public function create(Request $request)
	{
		
		$user = User::create($request->all());

		//dd($user);
		
		return view('users.show', compact('user'));
	}
}