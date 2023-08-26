<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class TemporaryFile extends Model {
	use HasUuids;

	public function getPath() {
		return config('filepond.upload_dir') . '/' . $this->id;
	}

	public function getStoragePath() {
		return Storage::path($this->getPath());
	}
}
