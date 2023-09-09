<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OAuthProvider extends Model {
	use HasFactory;

	protected $table = 'oauth_providers';

	protected $fillable = [
		'id',
		'token',
		'refresh_token',
		'expires_in',
		'user_id'
	];
}
