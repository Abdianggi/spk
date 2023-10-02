<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontEndController extends Controller
{
    function index() {
        return view('pages.frontend.home.index');
    }
}
