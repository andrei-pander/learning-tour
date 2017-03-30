<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAutostartToTours extends Migration {
	protected $table = 'tours';
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table($this->table, function (Blueprint $table) {
			$table->boolean('autostart')->default(false);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table($this->table, function (Blueprint $table) {
			$table->drop('autostart');
		});
	}
}
