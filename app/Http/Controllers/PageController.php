<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\PublicPage;

class PageController extends Controller
{
    public function index()
    {
        $page = PublicPage::where('route', '/')->first();

        return view('public.landing')
            ->with('page', $page);
    }

    public function getPage($slug = null)
    {
        $page = PublicPage::where('route', $slug);
        $page = $page->firstOrFail();
        dd($page);

        return view('public.about')->with('page', $page);
    }
}
