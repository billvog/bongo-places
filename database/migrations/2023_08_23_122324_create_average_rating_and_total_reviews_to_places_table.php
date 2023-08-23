<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void {
		Schema::table('places', function (Blueprint $table) {
			$table->float('average_rating', 3, 1)->default(0);
			$table->integer('total_reviews_count', false, true)->default(0);
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void {
		Schema::table('places', function (Blueprint $table) {
			$table->dropColumn(['average_rating', 'total_reviews_count']);
		});
	}
};
