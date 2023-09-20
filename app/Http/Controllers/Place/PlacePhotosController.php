<?php

namespace App\Http\Controllers\Place;

use App\Enums\Place\PlaceStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Place\UpdatePlacePhotosRequest;
use App\Http\Resources\PlacePhotosResource;
use App\Models\Place\Place;
use App\Models\Place\PlacePhotos;
use App\Models\TemporaryFile;

class PlacePhotosController extends Controller {
	public function edit(Place $place) {
		return view('places.photos.edit', [
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

		$placePhotos = PlacePhotos::query()->firstOrCreate(
			['place_id' => $place->id]
		);

		// If Place has media already attached to it, 
		// start counting $currentOrder from the $order 
		// of the last media.
		if ($placePhotos->medially->count() > 0) {
			$currentOrder = $placePhotos->medially->last()->order + 1;
		}

		foreach ($temporaryFiles as $tempFile) {
			// Uploads file to cloudinary and 
			// creates a bond with the place models.
			$placePhotos->attachRemoteMedia($tempFile->getStoragePath(), $currentOrder);

			$currentOrder++;
		}

		// Remove temporary files.
		TemporaryFile::destroy($files);

		// Fetch all photos for place, including those
		// which where just uploaded.
		$placePhotos = PlacePhotos::query()->where(['place_id' => $place->id])->first();

		return new PlacePhotosResource($placePhotos);
	}

	public function update(UpdatePlacePhotosRequest $request, Place $place) {
		$images = $request->validated('images');

		foreach ($images as $image) {
			$media = $place->photos->medially()->find($image['id']);

			if (array_key_exists('deleted', $image) && $image['deleted'] == true) {
				$place->photos->detachMedia($media);
				continue;
			}

			$media->order = $image['order'];
			$media->update();
		}

		// If `photos` are now less than 2 and the place is published,
		// change its status to draft.
		if ($place->status == PlaceStatus::Published && $place->photos()->exists() && $place->photos->medially()->count() < 2) {
			$place->update([
				'status' => PlaceStatus::Draft
			]);
		}

		return response()->noContent(200);
	}
}
