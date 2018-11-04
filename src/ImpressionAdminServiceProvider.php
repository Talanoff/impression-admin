<?php

namespace Talanoff\ImpressionAdmin;

class ImpressionAdminServiceProvider extends Illuminate\Support\ServiceProvider
{
	public function register()
	{
		$this->mergeConfigFrom(__DIR__.'/configs/impression-admin.php', 'impression-admin');

    $this->loadViewsFrom(__DIR__.'/views', 'admin');
	}

	public function boot()
	{
		//
	}
}