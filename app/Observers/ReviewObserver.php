<?php

namespace App\Observers;

use App\Models\Place\Place;
use App\Models\Review\Review;

class ReviewObserver {
	/**
	 * Handle the Review "created" event.
	 */
	public function created(Review $review): void {
		if (get_class($review->reviewable) == Place::class) {
			$place = $review->reviewable;

			// Update average place rating.
			$newAvgRating = (($place->average_rating * $place->total_reviews_count) + $review->rating) / ($place->total_reviews_count + 1);
			$place->average_rating = round($newAvgRating, 1);
			$place->average_rating = min($place->average_rating, 5);

			$place->total_reviews_count += 1;
			$place->save();
		}
	}

	/**
	 * Handle the Review "updated" event.
	 */
	public function updated(Review $review): void {
		if (get_class($review->reviewable) == Place::class) {
			$place = $review->reviewable;

			if (!$review->wasChanged('rating'))
				return;

			// Update average place rating.
			$oldRating = $review->getOriginal('rating', 0);
			$newRating = $review->rating;

			$ratingSum = $place->average_rating * $place->total_reviews_count;
			$ratingSum -= $oldRating;
			$ratingSum += $newRating;

			$newAvgRating = $ratingSum / $place->total_reviews_count;
			$place->average_rating = round($newAvgRating, 1);
			$place->average_rating = min($place->average_rating, 5);

			$place->save();
		}
	}

	/**
	 * Handle the Review "deleted" event.
	 */
	public function deleted(Review $review): void {
		if (get_class($review->reviewable) == Place::class) {
			$place = $review->reviewable;

			// Update average place rating.
			if ($place->total_reviews_count == 1) {
				$place->average_rating = 0;
				$place->total_reviews_count = 0;
			} else {
				$newAvgRating = (($place->average_rating * $place->total_reviews_count) - $review->rating) / ($place->total_reviews_count - 1);
				$place->average_rating = round($newAvgRating, 1);
				$place->average_rating = max($place->average_rating, 0);

				$place->total_reviews_count -= 1;
			}

			$place->save();
		}
	}
}
