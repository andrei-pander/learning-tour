<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTourStatuses extends Migration {
	private $table = 'tour_statuses';

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create($this->table, function (Blueprint $table) {
			$table->increments('id');
			$table->integer('tour_id')->unsigned();
			$table->integer('user_id');
			$table->integer('step_id')->unsigned();
			$table->timestamp('completed_at')->nullable();
			$table->timestamps();

			$table->foreign('tour_id')
				->references('id')
				->on('tours')
				->onDelete('restrict')
				->onUpdate('restrict');

			$table->foreign('user_id')
				->references('id')
				->on('users')
				->onDelete('restrict')
				->onUpdate('restrict');

			$table->foreign('step_id')
				->references('id')
				->on('tour_steps')
				->onDelete('restrict')
				->onUpdate('restrict');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop($this->table);
	}
}
