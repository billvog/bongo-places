<?php

use App\Models\Place;
use App\Models\PlaceLogo;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void {
		Place::all()->each(
			function (Place $place) {
				$oldPlaceLogo = $place->logo;
				if (is_null($oldPlaceLogo)) {
					return;
				}

				$placeLogo = new PlaceLogo();
				$placeLogo->place_id = $place->id;
				$placeLogo->media_id = $oldPlaceLogo->id;
				$place->logo()->save($placeLogo);

				$oldPlaceLogo->medially()->associate($placeLogo);
				$oldPlaceLogo->save();
			}
		);
	}
};
