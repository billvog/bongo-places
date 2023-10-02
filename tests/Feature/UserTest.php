<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Models\User\User;
use App\Models\Place\Place;
use App\Models\Review\Review;

class UserTest extends TestCase {
	use RefreshDatabase;

	/**
	 * Test if a User can create a Place.
	 */
	public function testUserCanCreatePlace(): void {
		$user = User::factory()->create();
		$place = Place::factory()->make();

		$user->places()->save($place);

		$this->assertDatabaseHas(Place::class, ['owner_id' => $user->id]);
	}

	/**
	 * Test if a user can create a Review.
	 *
	 * Note: The user that has created a Place, hence the owner of it,
	 *       cannot create review for it.
	 *       Only other users that are not in any way associated with the
	 *       Place can create a review.
	 */
	public function testUserCanCreateReview(): void {
		$userWithPlace = User::factory()->create();
		$userWithReview = User::factory()->create();

		$place = Place::factory()->make();

		$userWithPlace->places()->save($place);

		$review = Review::factory()->make(
			['reviewer_id' => $userWithReview->id]
		);

		$place->reviews()->save($review);

		$this->assertDatabaseHas(Place::class, ['owner_id' => $userWithPlace->id]);
		$this->assertDatabaseHas(Review::class, [
			'reviewer_id' => $userWithReview->id,
			'reviewable_type' => get_class($place),
			'reviewable_id' => $place->id
		]);
	}
}
