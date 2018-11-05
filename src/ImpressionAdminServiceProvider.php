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
		//
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
			__DIR__ . '/services' => base_path('app/Services'),
		], 'services');
	}
}