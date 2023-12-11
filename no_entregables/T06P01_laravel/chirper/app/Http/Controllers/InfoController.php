<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class InfoController extends Controller
{
    public function infoServer(): View
    {
        return view('phpinfo');
    }
}
