<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void {
		Schema::table('users', function (Blueprint $table) {
			$table->dropColumn([
				'google_id', 'google_token', 'google_refresh_token'
			]);
		});
	}
};
