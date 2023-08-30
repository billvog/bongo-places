<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePlacePhotosRequest;
use App\Models\Place;
use App\Models\TemporaryFile;
use Illuminate\Http\Request;

class PlacePhotosController extends Controller {
	public function create(Place $place) {
		return view('places.photos.create', [
			'place' => $place
		]);
	}

	public function store(Place $place, Request $request) {
		// Filepond puts here an array of uuids
		// that are the ids of TemporaryFiles
		$files = $request->get('file');

		// Find all temporary files for this request.
		$temporaryFiles = TemporaryFile::query()->findMany($files);

		$currentOrder = 0;

		// If Place has media already attached to it, 
		// start counting $currentOrder from the $order 
		// of the last media.
		if ($place->medially->count() > 0) {
			$currentOrder = $place->medially->last()->order + 1;
		}

		foreach ($temporaryFiles as $tempFile) {
			// Uploads file to cloudinary and 
			// creates a bond with the place models.
			$place->attachRemoteMedia($tempFile->getStoragePath(), $currentOrder);

			$currentOrder++;
		}

		// Remove temporary files.
		TemporaryFile::destroy($files);

		return redirect()->action([PlacePhotosController::class, 'edit'], ['place' => $place]);
	}

	public function edit(Place $place) {
		return view('places.photos.edit', [
			'place' => $place
		]);
	}

	public function update(UpdatePlacePhotosRequest $request, Place $place) {
		$images = $request->validated('images');

		foreach ($images as $image) {
			$media = $place->medially()->find($image['id']);

			if (array_key_exists('deleted', $image) && $image['deleted'] == true) {
				$place->detachMedia($media);
				continue;
			}

			$media->order = $image['order'];
			$media->update();
		}

		return response()->noContent(200);
	}
}
