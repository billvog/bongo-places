<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void {
		Schema::table('oauth_providers', function (Blueprint $table) {
			$table->string('name')->default('google');
			$table->string('friendly_name')->default('Google');
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void {
		Schema::table('oauth_providers', function (Blueprint $table) {
			$table->dropColumn([
				'name',
				'friendly_name'
			]);
		});
	}
};
