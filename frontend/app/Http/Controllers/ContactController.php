<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $contact = ContactUs::first();
        if (!$contact) {
            $contact = new ContactUs();
        }
        return view('pages.contact', compact('contact'));
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'message' => 'required|string',
        ]);

        $enquiry = \App\Models\ContactEnquiry::create($request->only(['name', 'email', 'phone', 'message']));

        $adminEmail = env('ADMIN_EMAIL');
        if ($adminEmail) {
            try {
                \Illuminate\Support\Facades\Mail::to($adminEmail)->send(new \App\Mail\ContactFormMail($enquiry));
            } catch (\Exception $e) {
                // Log exception safely if mail fails, but don't stop the user experience
                \Illuminate\Support\Facades\Log::error('Mail sending failed: '.$e->getMessage());
            }
        }

        return redirect()->back()->with('success', 'Thank you for your message! We will get back to you soon.');
    }
}
