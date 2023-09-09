<?php

namespace App\Http\Controllers\Place;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MyPlacesController extends Controller {
	public function index() {
		return view('my-places.index', [
			'places' => Auth::user()->places
		]);
	}
}
