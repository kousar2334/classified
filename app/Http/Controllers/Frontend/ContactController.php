<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ContactUsMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function contactPage(): View
    {
        return view('frontend.pages.contact');
    }

    public function sendMessage(Request $request): RedirectResponse
    {
        $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email|max:150',
            'subject' => 'required|string|max:200',
            'message' => 'required|string|max:3000',
        ]);

        ContactUsMessage::create([
            'name'    => xss_clean($request->name),
            'email'   => $request->email,
            'subject' => xss_clean($request->subject),
            'message' => xss_clean($request->message),
        ]);

        return redirect()->back()->with('success', 'Your message has been sent successfully. We will get back to you soon!');
    }
}
