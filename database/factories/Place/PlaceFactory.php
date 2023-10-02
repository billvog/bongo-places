<?php

namespace Database\Factories\Place;

use Illuminate\Database\Eloquent\Factories\Factory;
use MatanYadaev\EloquentSpatial\Objects\Point;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Place\Place>
 */
class PlaceFactory extends Factory {
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array {
		return [
			'name' => fake()->realTextBetween(5, 30),
			'description' => fake()->text(),
			'location' => fake()->streetAddress(),
			'coordinates' => new Point(fake()->latitude(), fake()->longitude())
		];
	}
}
