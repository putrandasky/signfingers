<?php

namespace App\Http\Controllers\Sitemap;

use App\Http\Controllers\Controller;

class SitemapController extends Controller
{
    public function index()
    {
        return response()->view('sitemap.index')->header('Content-Type', 'text/xml');

    }
}
