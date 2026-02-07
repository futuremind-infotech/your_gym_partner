<?php

namespace App\Controllers;

class Frontend extends BaseController
{
    public function index()
    {
        return view('frontend/index');
    }

    public function about()
    {
        return view('frontend/about');
    }

    public function contact()
    {
        return view('frontend/contact');
    }

    public function blog()
    {
        return view('frontend/blog');
    }

    public function gallery()
    {
        return view('frontend/gallery');
    }

    public function pricing()
    {
        return view('frontend/pricing');
    }
}
