<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

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
