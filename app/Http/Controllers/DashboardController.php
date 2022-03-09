<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('admin');
    }

    public function home()
    {
        // dd(auth()->user());
        $pageConfigs = ['pageHeader' => false];

        return view(
            '/content/dashboard',
            ['pageConfigs' => $pageConfigs]
        );
    }
}
