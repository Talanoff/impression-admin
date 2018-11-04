<?php

namespace Talanoff\ImpressionAdmin;

class ImpressionAdminServiceProvider extends \Illuminate\Support\ServiceProvider
{
	public function register()
	{
		$this->mergeConfigFrom(__DIR__.'/configs/impression-admin.php', 'impression-admin');
	}

	public function boot()
	{
		$this->loadViewsFrom(__DIR__.'/views', 'impression-admin');

    $this->publishes([
        __DIR__.'/views' => resource_path('views/admin'),
        __DIR__.'/js' => resource_path('js'),
        __DIR__.'/sass' => resource_path('sass'),
    ]);
	}
}