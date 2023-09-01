<?php

namespace App\Observers;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use CloudinaryLabs\CloudinaryLaravel\Model\Media;


/**
 * This observer gets notified when we remove $media
 * from our database and automatically deletes the associated
 * file on Cloudinary Servers for us.
 */
class CloudinaryMediaObserver {
	/**
	 * Helper function to delete media from cloudinary.
	 */
	function deleteMediaFromCloudinary(Media $media) {
		Cloudinary::destroy($media->file_name);
	}

	/**
	 * Handle the Media "deleted" event.
	 */
	public function deleted(Media $media): void {
		$this->deleteMediaFromCloudinary($media);
	}

	/**
	 * Handle the Media "force deleted" event.
	 */
	public function forceDeleted(Media $media): void {
		$this->deleteMediaFromCloudinary($media);
	}
}
