<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Models\Place;
use App\Models\Review;
use App\Models\User;

class ReviewController extends Controller {
	public function __construct() {
		$this->middleware('auth')->only(['create', 'store', 'edit', 'update', 'destroy']);
	}

	/**
	 * Display a listing of the resource.
	 */
	public function index(Place $place) {
		return view('places.reviews.index', [
			'place' => $place,
			'reviews' => $place->reviews
		]);
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create(Place $place) {
		return view('places.reviews.create', [
			'place' => $place
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Place $place, StoreReviewRequest $request) {
		$review = new Review(
			$request->all(['review_text', 'rating'])
		);

		$review->reviewer_id = auth()->user()->id;

		$place->reviews()->save($review);

		return redirect()->action([ReviewController::class, 'show'], [
			'place' => $place,
			'review' => $review
		]);
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(Review $review) {
		//
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(UpdateReviewRequest $request, Review $review) {
		//
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(Review $review) {
		//
	}
}
