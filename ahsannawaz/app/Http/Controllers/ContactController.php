<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class ContactController extends Controller
{
    public function show()
    {
        return view('contact');
    }

    public function store(Request $request)
    {
        // Honeypot — bots fill hidden fields, humans never see them.
        if ($request->filled('website')) {
            return back()->with('contact_success', 'Thanks! Your message has been sent.')
                ->withFragment('contact');
        }

        // Max 5 submissions per hour per IP.
        $key = 'contact:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $minutes = ceil(RateLimiter::availableIn($key) / 60);

            return back()
                ->withErrors(['contact' => "You've sent several messages already. Please try again in {$minutes} minute(s)."])
                ->withInput()
                ->withFragment('contact');
        }

        $data = $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email|max:150',
            'subject' => 'required|string|max:200',
            'message' => 'required|string|min:10|max:5000',
            'budget'  => 'nullable|string|max:50',
        ], [
            'message.min' => 'Please add a little more detail (at least 10 characters).',
        ]);

        RateLimiter::hit($key, 3600);

        $data['ip_address'] = $request->ip();
        ContactMessage::create($data);

        return back()
            ->with('contact_success', "Thanks {$data['name']}! Your message has been sent — I'll get back to you soon.")
            ->withFragment('contact');
    }
}
