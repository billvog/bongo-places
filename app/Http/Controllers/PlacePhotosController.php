<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\TemporaryFile;
use Illuminate\Http\Request;

class PlacePhotosController extends Controller {
	public function create(Place $place) {
		return view('places.create-steps.two', [
			'place' => $place
		]);
	}

	public function store(Request $request) {
		$files = $request->get('file');
		$temporaryFiles = TemporaryFile::query()->findMany($files);

		dd($temporaryFiles);

		// TODO: upload files to cloudinary.
	}
}
