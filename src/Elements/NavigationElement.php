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
        $this->route = "backend.{$route}.index";
		$this->icon = $icon;

		$this->compare = $compare ? "backend.{$route}.{$compare}" : null;

        $this->unread = $unread;
    }
}
