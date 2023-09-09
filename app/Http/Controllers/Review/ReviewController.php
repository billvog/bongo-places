<?php

namespace App\Http\Controllers\Review;

use Closure;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Place\PlaceController;
use App\Http\Requests\Review\StoreReviewRequest;
use App\Http\Requests\Review\UpdateReviewRequest;
use App\Models\Review\Review;
use App\Models\Place\Place;

class ReviewController extends Controller {
	public function __construct() {
		$this->middleware('auth')->only(['create', 'store', 'edit', 'update', 'destroy']);

		// Ensure user hasn't already reviewed the place.
		$this->middleware(function (Request $request, Closure $next) {
			$place = $request->route('place');
			if (
				$place &&
				Review::where([
					'reviewable_type' => get_class($place),
					'reviewable_id' => $place->id,
					'reviewer_id' => auth()->user()->id
				])->exists()
			) {
				return redirect()
					->action([PlaceController::class, 'show'], ['place' => $place])
					->with('notice', 'You have already reviewed this place.');
			}

			return $next($request);
		})->only(['create', 'store']);
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

		return redirect()->action([PlaceController::class, 'show'], [
			'place' => $place
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
