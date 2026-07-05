<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AboutUs;

class AboutController extends Controller
{
    public function index()
    {
        $about = \App\Models\AboutUs::first() ?? new \App\Models\AboutUs();
        $settings = \App\Models\HomeSetting::first() ?? new \App\Models\HomeSetting();
        return view('pages.about', compact('about', 'settings'));
    }
}
