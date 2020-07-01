<?php

namespace App\Http\Controllers\Website;

use App;
use App\Http\Controllers\Controller;

class WebsiteController extends Controller
{
    public function homePage($locale = '')
    {
        if ($locale == 'id') {
            App::setLocale('id');
        }
        return view('apps.website');

    }
}
