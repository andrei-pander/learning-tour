<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTourSteps extends Migration {
	private $table = 'tour_steps';

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create($this->table, function (Blueprint $table) {
			$table->increments('id');
			$table->integer('tour_id')->unsigned();
			$table->string('title');
			$table->text('content');
			$table->string('target');
			$table->string('placement');
			$table->boolean('show_prev_button')->default(false);
			$table->boolean('show_next_button')->default(true);
			$table->boolean('next_on_target_click')->default(false);
			$table->string('route');
			$table->integer('order')->unsigned();
			$table->boolean('active')->default(false);
			$table->boolean('multipage')->default(false);
			$table->timestamps();

			$table->foreign('tour_id')
				->references('id')
				->on('tours')
				->onDelete('restrict');
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
