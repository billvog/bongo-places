<?php

namespace App\Models;

use CloudinaryLabs\CloudinaryLaravel\MediaAlly;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
