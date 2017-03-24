<?php

namespace Majesko\LearningTour;

use Illuminate\Support\ServiceProvider;

class LearningTourProvider extends ServiceProvider
{
	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot() {
		$this->publishes([
			__DIR__.'/config/learningtour.php' => config_path('learningtour.php'),
		], 'config');
		$this->publishes([
			__DIR__ . '/database/migrations' => database_path('migrations')
		], 'migrations');
		$this->loadViewsFrom(__DIR__ . '/resources/views', 'learningtour');
		$this->loadTranslationsFrom(__DIR__.'/resources/lang', 'learningtour');
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register() {
		$this->mergeConfigFrom(
			__DIR__.'/config/learningtour.php', 'learningtour'
		);
	}
}
