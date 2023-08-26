<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\TemporaryFile;
use Illuminate\Http\Request;
use SplFileInfo;

class PlacePhotosController extends Controller {
	public function create(Place $place) {
		return view('places.create-steps.two', [
			'place' => $place
		]);
	}

	public function store(Place $place, Request $request) {
		// Filepond puts here an array of uuids
		// that are the ids of TemporaryFiles
		$files = $request->get('file');

		// Find all temporary files for this request.
		$temporaryFiles = TemporaryFile::query()->findMany($files);

		foreach ($temporaryFiles as $tempFile) {
			// Cloudinary MediaAlly attachMedia function 
			// expects a subclass of SplFileInfo (I guess)
			// so, we need to create an instance of SplFileInfo
			// from the path of our temporary file.
			$fileInfo = new SplFileInfo($tempFile->getStoragePath());

			// Uploads file to cloudinary and 
			// creates a bond with the place models.
			$place->attachMedia($fileInfo);
		}

		// Remove temporary files.
		TemporaryFile::destroy($files);

		return redirect()->action([PlaceController::class, 'show'], ['place' => $place]);
	}
}
