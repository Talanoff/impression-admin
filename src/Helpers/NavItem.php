<?php

namespace Talanoff\ImpressionAdmin\Helpers;

class NavItem
{
	public $name;
	public $route;
	public $compare;
	public $icon;
	public $unread;
	public $submenu;

	public function __construct($args)
	{
		if (!is_array($args)) {
			return null;
		}

		$args = (object)$args;

		$this->name = $args->name;
		$this->icon = $args->icon ?? 'i-settings';
		$this->route = config('ib-admin.admin.prefix') . ".{$args->route}.index";
		$this->unread = $args->unread ?? null;

		if (isset($args->compare)) {
			if (is_array($args->compare)) {
				$current = explode('.', app('router')->currentRouteName());
				$this->compare = collect($current)->contains(function ($r) use ($args) {
					return in_array($r, $args->compare);
				});
			} else {
				$this->compare =
					app('router')->currentRouteNamed(config('ib-admin.admin.prefix') . ".{$args->route}.{$args->compare}");
			}
		} else {
			$this->compare = app('router')->currentRouteNamed(config('ib-admin.admin.prefix') . ".{$args->route}.*");
		}

		if (isset($args->submenu)) {
			$this->submenu = (object)$args->submenu;
		} else {
			$this->submenu = null;
		}
	}
}
