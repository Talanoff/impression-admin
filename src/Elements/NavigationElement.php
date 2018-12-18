<?php

namespace Talanoff\ImpressionAdmin\Elements;

class NavigationElement
{
	public $name;
	public $route;
	public $compare;
	public $icon;
	public $unread;
	public $submenu;

	public function __construct($name, $route, $icon = 'i-settings', $compare = '*', $unread = null, $submenu = [])
	{
		$this->name = $name;
		$this->route = config('impression-admin.route') . ".{$route}.index";
		$this->icon = $icon;
		$this->compare = $compare ? config('impression-admin.route') . ".{$route}.{$compare}" : null;
		$this->unread = $unread;
		$this->submenu = (object) $submenu;
	}
}
