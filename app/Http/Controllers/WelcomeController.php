<?php namespace App\Http\Controllers;

use App\Campaign;
use Auth;

class WelcomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//$this->middleware('guest');
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		$campaigns = Campaign::all();
		return view('welcome')->with('campaigns', $campaigns);
	}

	public function account(){
		if (Auth::check()){
			$user = Auth::user();
			return view('user')->with('user', $user);
		}

		return view('auth.login');
	}

}
