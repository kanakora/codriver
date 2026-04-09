<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Mail\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use Inertia\Response;

class ContactController extends Controller
{
    /**
     * Show the contact page.
     */
    public function index(): Response
    {
        return Inertia::render('Contact');
    }

    /**
     * Send the contact message.
     */
    public function send(ContactRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // Send email to admin
        Mail::to(config('mail.admin_email'))
            ->send(new ContactMessage($validated));

        return redirect()->route('contact')
            ->with('success', 'Your message has been sent successfully. We\'ll get back to you soon!');
    }
}
