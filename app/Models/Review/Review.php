<?php

namespace App\Models\Review;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model {
	use HasFactory;
	use HasUuids;

	protected $fillable = [
		'review_text',
		'rating'
	];

	protected $casts = [
		'rating' => 'float'
	];

	public function reviewable(): MorphTo {
		return $this->morphTo();
	}

	public function reviewer() {
		return $this->belongsTo(User::class);
	}
}
