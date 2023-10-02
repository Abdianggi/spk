<?php

namespace App\View\Components\Layouts;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Sidebar extends Component
{
    private $item;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->item = [
            [
                'name' => 'Menu',
                'link' => null,
                'isActive' => null,
                'isEnabled' => true,
                'icon' => null,
                'children' => [
                    [
                        'name' => 'Dashboard',
                        'data-id' => 'dashboard',
                        'url' => route('dashboard'),
                        'isActive' => request()->routeIs('dashboard'),
                        'isEnabled' => true,
                        'icon' => 'bi bi-grid-fill',
                        'children' => []
                    ],
                    [
                        'name' => 'Users Data',
                        'data-id' => 'user',
                        'url' => route('master.user.index'),
                        'isActive' => request()->routeIs('master.user.index'),
                        'isEnabled' => true,
                        'icon' => 'bi bi-people',
                        'children' => []
                    ],
                    [
                        'name' => 'Penduduk',
                        'data-id' => 'penduduk',
                        'url' => route('master.penduduk.index'),
                        'isActive' => request()->routeIs('master.penduduk.index'),
                        'isEnabled' => true,
                        'icon' => 'bi bi-people',
                        'children' => []
                    ],
                    // [
                    //     'name' => 'Family Data',
                    //     'url' => route('master.family.index'),
                    //     'isActive' => false,
                    //     'isEnabled' => true,
                    //     'icon' => 'bi bi-people',
                    //     'children' => []
                    // ],
                ]
            ],
        ];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layouts.sidebar', [
            'sidebarItems' => $this->item
        ]);
    }
}
