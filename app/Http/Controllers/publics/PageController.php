<?php

namespace App\Http\Controllers\publics;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\PublicPage;

class PageController extends Controller
{
    public function index()
    {
        $maindata = PublicPage::where('route', '/')->first();

        return view('public.page')
        ->with('maindata', $maindata);
    }

    public function getPage($slug = null)
    {
        $maindata = PublicPage::where('route', $slug);
        $maindata = $maindata->firstOrFail();

        return view('public.page')->with('maindata', $maindata);
    }
}
