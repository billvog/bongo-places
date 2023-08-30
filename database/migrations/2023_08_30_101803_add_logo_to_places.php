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
			$table
				->foreignId('logo_id')
				->nullable()
				->references('id')
				->on('media');
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void {
		Schema::table('places', function (Blueprint $table) {
			$table->dropConstrainedForeignId('logo_id');
		});
	}
};
