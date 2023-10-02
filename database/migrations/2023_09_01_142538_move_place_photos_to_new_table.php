<?php

use App\Models\Place\Place;
use App\Models\Place\PlacePhotos;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void {
		Place::all()->each(
			function (Place $place) {
				$placePhotos = new PlacePhotos();
				$place->photos()->save($placePhotos);

				$media = $place->medially;
				foreach ($media as $photo) {
					$photo->medially()->associate($placePhotos);
					$photo->save();
				}
			}
		);
	}
};
