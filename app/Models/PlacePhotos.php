<?php

namespace App\Models;

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
