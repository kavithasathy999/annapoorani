<?php

namespace App\Http\Controllers;

use App\Models\SeoData;
use Illuminate\Http\Request;

class SeoController extends Controller
{
    public function show(string $url)
    {
        $seo = SeoData::where('url', $url)->firstOrFail();

        $related = SeoData::where('seo_headingId', $seo->seo_headingId)
            ->where('id', '!=', $seo->id)
            ->limit(5)
            ->get();

        return view('pages.seo', compact('seo', 'related'));
    }

}
