<?php

namespace Talanoff\ImpressionAdmin\Elements;

class NavigationElement
{
	public $name;
	public $route;
	public $compare;
	public $icon;
	public $unread;

	public function __construct($name, $route, $icon, $compare = '*', $unread = null)
	{
		$this->name = $name;
		$this->route = config('impression-admin.route') . ".{$route}.index";
		$this->icon = $icon;
		$this->compare = $compare ? config('impression-admin.route') . ".{$route}.{$compare}" : null;
		$this->unread = $unread;
	}
}
