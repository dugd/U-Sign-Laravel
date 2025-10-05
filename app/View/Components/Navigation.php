<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Navigation extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $menuItems = [
            ['title' => 'Home', 'url' => route('home')],
            ['title' => 'Gestures', 'url' => route('gestures.index')],
            ['title' => 'Profile', 'url' => route('profile.edit')],
        ];

        return view('components.navigation', ['menuItems' => $menuItems]);
    }
}
