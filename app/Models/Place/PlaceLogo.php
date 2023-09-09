<?php

namespace App\Models\Place;

use Illuminate\Database\Eloquent\Model;
use CloudinaryLabs\CloudinaryLaravel\MediaAlly;

class PlaceLogo extends Model {
	use MediaAlly;

	protected $fillable = [
		'place_id',
	];

	public function place() {
		$this->belongsTo(Place::class);
	}

	public function getSecureUrl(): string {
		return $this->medially()->first()->getSecurePath();
	}
}
