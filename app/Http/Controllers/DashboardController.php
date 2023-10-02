<?php

namespace App\Http\Controllers;

use Illuminate\View\View;


class DashboardController extends Controller
{
    /**
     * Invokable
     *
     * @return View
     */
    public function __invoke()
    {
        return view('pages.dashboard.index', [
            'title' => "Dashboard"
        ]);
        
    }
}
