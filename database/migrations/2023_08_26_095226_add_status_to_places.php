<?php

use App\Enums\PlaceStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void {
		Schema::table('places', function (Blueprint $table) {
			$table->string('status')->default(PlaceStatus::Draft->value);
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void {
		Schema::table('places', function (Blueprint $table) {
			$table->dropColumn('status');
		});
	}
};
