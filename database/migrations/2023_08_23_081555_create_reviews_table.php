<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void {
		Schema::create('reviews', function (Blueprint $table) {
			$table->uuid('id')->primary();

			// Relation to the user that has made the review.
			$table->foreignUuid('reviewer_id')
				->references('id')
				->on('users')
				->cascadeOnDelete();

			// Polymorphic relation to a model that can be reviewed.
			$table->uuidMorphs('reviewable');

			// Review text and rating
			$table->text('review_text');
			$table->float('rating', 3, 1);

			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void {
		Schema::dropIfExists('reviews');
	}
};
