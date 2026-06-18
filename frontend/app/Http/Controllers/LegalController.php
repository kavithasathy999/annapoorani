<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TermCondition;

class LegalController extends Controller
{
    public function terms()
    {
        $terms = TermCondition::first();
        return view('pages.terms', compact('terms'));
    }
}
