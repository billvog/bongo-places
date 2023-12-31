<?php

namespace App\Providers;

use App\Models\Review\Review;
use App\Models\TemporaryFile;
use App\Observers\CloudinaryMediaObserver;
use App\Observers\ReviewObserver;
use App\Observers\TemporaryFileObserver;
use CloudinaryLabs\CloudinaryLaravel\Model\Media;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider {
	/**
	 * The event to listener mappings for the application.
	 *
	 * @var array<class-string, array<int, class-string>>
	 */
	protected $listen = [
		Registered::class => [
			SendEmailVerificationNotification::class,
		],
	];

	/**
	 * Register any events for your application.
	 */
	public function boot(): void {
		// Register the ReviewObserver to update average rating of the reviewable parent.
		Review::observe(ReviewObserver::class);
		TemporaryFile::observe(TemporaryFileObserver::class);
		Media::observe(CloudinaryMediaObserver::class);
	}

	/**
	 * Determine if events and listeners should be automatically discovered.
	 */
	public function shouldDiscoverEvents(): bool {
		return false;
	}
}
