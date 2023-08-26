<?php

namespace App\Http\Controllers;

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
			'places' => Place::all()
		]);
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create() {
		return view('places.create-steps.one');
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

		$place->save();

		return redirect()->action([PlaceController::class, 'show'], ['place' => $place]);
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
		//
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(UpdatePlaceRequest $request, Place $place) {
		//
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(Place $place) {
		//
	}
}
