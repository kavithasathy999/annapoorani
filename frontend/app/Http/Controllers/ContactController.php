<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $contact = ContactUs::first() ?? new ContactUs();
        return view('pages.contact', compact('contact'));
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'name' => 'required|string|regex:/^[a-zA-Z\s]+$/|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|regex:/^[0-9]{10}$/',
            'message' => ['required', 'string', function ($attribute, $value, $fail) {
                $wordCount = str_word_count($value);
                if ($wordCount > 50) {
                    $fail('The '.$attribute.' must not exceed 50 words.');
                }
            }],
        ]);

        $enquiry = \App\Models\ContactEnquiry::create($request->only(['name', 'email', 'phone', 'message']));

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Thank you for your message! We will get back to you soon.',
                'admin_whatsapp' => env('ADMIN_WHATSAPP_NUMBER', '6380195167'),
                'enquiry' => $enquiry
            ]);
        }

        return redirect()->back()->with('success', 'Thank you for your message! We will get back to you soon.');
    }
}
