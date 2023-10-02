<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    public $data = [];

    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    public function __get($name)
    {
        return $this->data[$name];
    }

    public function __isset($name)
    {
        return isset($this->data[ $name ]);
    }

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            // $this->settings         = Setting::get();
            // $this->auth             = User::find(auth()->user()->id);
            // $this->roleName         = $this->auth->getRoleNames()[0];
            // if ($this->roleName == 'Bride') {
            //     $this->userInvit    = Invitation::whereUserId($this->auth->id)->first();
            // }
            // dd($this->roleName);
            return $next($request);
        });
    }
}
