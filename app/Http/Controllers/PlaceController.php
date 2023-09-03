<?php

namespace App\Http\Controllers;

use App\Enums\PlaceStatus;
use App\Http\Requests\StorePlaceRequest;
use App\Http\Requests\UpdatePlaceRequest;
use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use MatanYadaev\EloquentSpatial\Objects\Point;

class PlaceController extends Controller {
	public function __construct() {
		$this->middleware('auth')->only(['create', 'store', 'edit', 'update', 'destroy']);
	}

	/**
	 * Display a listing of the resource.
	 */
	public function index() {
		return view('places.index', [
			'places' => Place::query()->where('status', PlaceStatus::Published->value)->get()
		]);
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create() {
		return view('places.create');
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(StorePlaceRequest $request) {
		$data = $request->validated();

		// Convert coordinates to Point class that Eloquent understands.
		$data['coordinates'] = new Point(
			$data['coordinates']['latitude'],
			$data['coordinates']['longitude']
		);

		$place = new Place($data);
		$place->owner_id = Auth::user()->id;
		$place->status = PlaceStatus::Draft;

		$place->save();

		return redirect()->action([PlacePhotosController::class, 'create'], ['place' => $place]);
	}

	/**
	 * Display the specified resource.
	 */
	public function show(Place $place) {
		return view('places.show', [
			'place' => $place
		]);
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(Place $place) {
		return view('places.edit', [
			'place' => $place
		]);
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(UpdatePlaceRequest $request, Place $place) {
		$data = $request->validated();

		// Convert coordinates to Point class that Eloquent understands.
		$data['coordinates'] = new Point(
			$data['coordinates']['latitude'],
			$data['coordinates']['longitude']
		);

		// If place->status has changed to `published` verify it meets
		// the requirements.
		if ($place->status->value != $data['status'] && $data['status'] == PlaceStatus::Published->value) {
			if ($place->hasLogo() == false) {
				return redirect()
					->action([PlaceController::class, 'edit'], ['place' => $place])
					->withInput()
					->with('notice', "To publish your place you need to upload a logo.");
			}

			if ($place->photos()->exists() && $place->photos->medially()->count() < 2) {
				return redirect()
					->action([PlaceController::class, 'edit'], ['place' => $place])
					->withInput()
					->with('notice', "To publish your place you need to upload at least two (2) photos.");
			}
		}

		$place->update($data);

		return redirect()->action([PlaceController::class, 'show'], ['place' => $place]);
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(Place $place) {
		//
	}
}
