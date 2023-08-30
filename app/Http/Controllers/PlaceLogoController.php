<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePlaceLogoRequest;
use App\Models\Place;
use App\Models\TemporaryFile;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use CloudinaryLabs\CloudinaryLaravel\Model\Media;

class PlaceLogoController extends Controller {
	public function edit(Place $place) {
		return view('places.logo.edit', [
			'place' => $place
		]);
	}

	public function update(Place $place, UpdatePlaceLogoRequest $request) {
		$logoTempId = $request->get('file');

		$temporaryFile = TemporaryFile::query()->find($logoTempId);

		if ($place->logo()->exists()) {
			// If $place already has a logo, we need to delete it
			// from Cloudinary ->
			Cloudinary::destroy($place->logo->getFileName());
			// and our database ->
			$place->logo->destroy();
		}

		// Upload file to Cloudinary
		$response = Cloudinary::uploadFile($temporaryFile->getStoragePath());

		// Save file details on our database
		$media = new Media();
		$media->file_name = $response->getFileName();
		$media->file_url = $response->getSecurePath();
		$media->size = $response->getSize();
		$media->file_type = $response->getFileType();
		$media->save();

		$place->logo_id = $media->id;
		$place->save();

		// Remove temporary file.
		TemporaryFile::destroy($logoTempId);

		return redirect()->action([PlaceLogoController::class, 'edit'], ['place' => $place]);
	}
}
