<?php

namespace App\Services;
use Talanoff\ImpressionAdmin\NavigationElement;

class Navigation
{
    public function frontend()
    {
        //
    }

    public function backend()
    {
        return [
             new NavigationElement('Пользователи', 'users', 'i-users'),
        ];
    }
}
