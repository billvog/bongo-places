<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePlaceRequest;
use App\Http\Requests\UpdatePlaceRequest;
use App\Models\Place;

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
		//
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(StorePlaceRequest $request) {
		//
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
