<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class UpdateTourStepDropTriggers extends Migration {
	protected $table = 'tour_steps';

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table($this->table, function (Blueprint $table) {
			$table->dropColumn('autostart');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table($this->table, function (Blueprint $table) {
			$table->string('triggers')->after('active')->nullable();
		});
	}
}
