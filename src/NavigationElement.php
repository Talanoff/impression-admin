<?php

namespace App\Services;

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
        $this->compare = "backend.{$route}.{$compare}";
        $this->icon = $icon;
        $this->unread = $unread;
    }
}
