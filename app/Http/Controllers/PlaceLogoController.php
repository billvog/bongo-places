<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePlaceLogoRequest;
use App\Models\Place;
use App\Models\PlaceLogo;
use App\Models\TemporaryFile;

class PlaceLogoController extends Controller {
	public function edit(Place $place) {
		return view('places.logo.edit', [
			'place' => $place
		]);
	}

	public function update(Place $place, UpdatePlaceLogoRequest $request) {
		$logoTempId = $request->get('file');
		if (str_starts_with($logoTempId, 'http')) {
			return redirect()
				->action([PlaceLogoController::class, 'edit'], $place)
				->with('notice', "Looks like you haven't uploaded a file.");
		}

		$temporaryFile = TemporaryFile::query()->find($logoTempId);
		if (is_null($temporaryFile)) {
			return redirect()
				->action([PlaceLogoController::class, 'edit'], $place)
				->with('notice', 'Something went wrong while upload your file.');
		}

		// If $place already has a logo, we need to delete it.
		if ($place->hasLogo()) {
			// `detachMedia()` will delete and disassociate all the 
			// associated media to this logo.
			// Deleting the file from Cloudinary is \App\Observers\CloudinaryMediaObserver's job.
			$place->logo->detachMedia();
			$place->logo()->delete();
		}

		$logo = new PlaceLogo();
		$place->logo()->save($logo);
		$logo->attachRemoteMedia($temporaryFile->getStoragePath());

		// Remove temporary file.
		TemporaryFile::destroy($logoTempId);

		return redirect()->action([PlaceLogoController::class, 'edit'], ['place' => $place]);
	}
}
