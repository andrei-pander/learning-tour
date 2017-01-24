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
		]);
		$this->publishes([
			__DIR__ . '/database/migrations' => database_path('migrations')
		], 'migrations');
		$this->loadViewsFrom(__DIR__ . '/views', 'learningtour');

		if ( ! app()->routesAreCached()) {
			require __DIR__ . '/Http/routes.php';
		}
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
