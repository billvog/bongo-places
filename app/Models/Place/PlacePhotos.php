<?php

namespace App\Models\Place;

use CloudinaryLabs\CloudinaryLaravel\MediaAlly;
use Illuminate\Database\Eloquent\Model;

class PlacePhotos extends Model {
	use MediaAlly;

	protected $fillable = [
		'place_id'
	];

	public function place() {
		$this->belongsTo(Place::class);
	}
}
