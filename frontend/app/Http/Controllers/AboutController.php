<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AboutUs;

class AboutController extends Controller
{
    public function index()
    {
        $about = AboutUs::first() ?? new AboutUs();
        $settings = \App\Models\HomeSetting::first() ?? new \App\Models\HomeSetting();
        return view('pages.about', compact('about', 'settings'));
    }
}
