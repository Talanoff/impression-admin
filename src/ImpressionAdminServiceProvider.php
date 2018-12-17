<?php

namespace Talanoff\ImpressionAdmin;

/**
 * Class ImpressionAdminServiceProvider
 * @package Talanoff\ImpressionAdmin
 */
class ImpressionAdminServiceProvider extends \Illuminate\Support\ServiceProvider
{
	public function register()
	{
		app()->singleton('nav', function() {
			return new \App\Services\Navigation();
		});
	}

	public function boot()
	{
		$this->loadViewsFrom(__DIR__ . '/views', 'impression-admin');

		$this->publishes([
			__DIR__ . '/views' => resource_path('views'),
		], 'views');

		$this->publishes([
			__DIR__ . '/assets/js' => resource_path('js/admin'),
			__DIR__ . '/assets/sass' => resource_path('sass/admin'),
			__DIR__ . '/assets/fonts' => resource_path('fonts'),
		], 'assets');

		$this->publishes([
			__DIR__ . '/Services' => base_path('app/Services'),
		], 'services');

		$this->publishes([
			__DIR__ . '/migrations' => base_path('app/database/migrations'),
		], 'migrations');

		$this->publishes([
			__DIR__ . '/configs' => base_path('config'),
		], 'config');
	}
}