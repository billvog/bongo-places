<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePlaceLocationRequest;
use App\Models\Place;
use MatanYadaev\EloquentSpatial\Objects\Point;

class PlaceLocationController extends Controller {
	public function edit(Place $place) {
		return view('places.location.edit', [
			'place' => $place
		]);
	}

	public function update(UpdatePlaceLocationRequest $request, Place $place) {
		$data = $request->validated();

		// Convert coordinates to Point class that Eloquent understands.
		$data['coordinates'] = new Point(
			$data['coordinates']['latitude'],
			$data['coordinates']['longitude']
		);

		$place->update($data);

		return redirect()->action([PlaceLocationController::class, 'edit'], ['place' => $place]);
	}
}
