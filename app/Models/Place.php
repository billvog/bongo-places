<?php

namespace App\Models;

use App\Enums\PlaceStatus;
use CloudinaryLabs\CloudinaryLaravel\MediaAlly;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Auth;
use MatanYadaev\EloquentSpatial\Objects\Point;
use MatanYadaev\EloquentSpatial\Traits\HasSpatial;

class Place extends Model {
	use HasFactory;
	use HasUuids;
	use HasSpatial;
	use MediaAlly;

	protected $fillable = [
		'name',
		'description',
		'location',
		'coordinates',
	];

	protected $casts = [
		'coordinates' => Point::class,
		'status' => PlaceStatus::class,
	];

	public function owner() {
		return $this->belongsTo(User::class);
	}

	public function reviews(): MorphMany {
		return $this->morphMany(Review::class, 'reviewable');
	}

	// A helper function to check if the current user has reviewed this places or not.
	public function haveReviewed(): bool {
		if (Auth::guest())
			return false;

		return $this->reviews->contains(function (Review $value, int $key) {
			return $value->reviewer_id === Auth::user()->id;
		});
	}
}
