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
			$table->string('password')->nullable()->change();
			$table->string('avatar_url')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void {
		Schema::table('users', function (Blueprint $table) {
			$table->string('password')->nullable(false)->change();
			$table->dropColumn('avatar_url');
		});
	}
};
