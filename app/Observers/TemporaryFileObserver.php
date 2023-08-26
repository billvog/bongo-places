<?php

namespace App\Observers;

use App\Models\TemporaryFile;
use Illuminate\Support\Facades\Storage;

class TemporaryFileObserver {
	/**
	 * Handle the TemporaryFile "deleted" event.
	 */
	public function deleted(TemporaryFile $temporaryFile): void {
		$temporaryFilePath = config('filepond.upload_dir') . '/' . $temporaryFile->id;
		Storage::delete($temporaryFilePath);
	}

	/**
	 * Handle the TemporaryFile "force deleted" event.
	 */
	public function forceDeleted(TemporaryFile $temporaryFile): void {
		$temporaryFilePath = config('filepond.upload_dir') . '/' . $temporaryFile->id;
		Storage::delete($temporaryFilePath);
	}
}
