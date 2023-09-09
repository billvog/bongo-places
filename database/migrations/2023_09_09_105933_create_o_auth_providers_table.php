<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void {
		Schema::create('oauth_providers', function (Blueprint $table) {
			// OAuth attributes
			$table->string('id')->primary();
			$table->string('token');
			$table->string('refresh_token')->nullable();
			$table->unsignedInteger('expires_in')->nullable();

			$table
				->foreignUuid('user_id')
				->references('id')
				->on('users');

			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void {
		Schema::dropIfExists('oauth_providers');
	}
};
