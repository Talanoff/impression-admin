<?php

namespace Talanoff\ImpressionAdmin;

/**
 * Class ImpressionAdminServiceProvider
 * @package Talanoff\ImpressionAdmin
 */
class ImpressionAdmin extends \Illuminate\Support\ServiceProvider
{
	public function register()
	{
		$this->mergeConfigFrom(__DIR__ . '/configs/impression-admin.php', 'impression-admin');
	}

	public function boot()
	{
		$this->loadViewsFrom(__DIR__ . '/views', 'impression-admin');

		$this->publishes([
			__DIR__ . '/views' => resource_path('views/admin'),
			__DIR__ . '/assets/js' => resource_path('js/admin'),
			__DIR__ . '/asset/sass' => resource_path('sass/admin'),
		]);
	}
}