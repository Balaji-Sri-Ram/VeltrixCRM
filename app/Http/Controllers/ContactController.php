<?php

namespace App\Http\Controllers;

use App\Mail\ContactInquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    /**
     * Handle incoming contact inquiries and dispatch email.
     */
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        try {
            // Send inquiry to the administrator's email ramuparasa02@gmail.com
            Mail::to('ramuparasa02@gmail.com')->send(new ContactInquiry(
                $validated['name'],
                $validated['email'],
                $validated['message']
            ));

            if ($request->expectsJson()) {
                return response()->json(['success' => true, 'message' => 'Thank you! Your query has been successfully submitted and transmitted.']);
            }

            return back()->with('contact_success', 'Thank you! Your query has been successfully submitted and transmitted.');
        } catch (\Exception $e) {
            Log::error('Contact form email dispatch failed: ' . $e->getMessage());

            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Apologies, we encountered an operational issue transmitting your query. Please try again.'], 500);
            }

            return back()->withInput()->with('contact_error', 'Apologies, we encountered an operational issue transmitting your query. Please try again.');
        }
    }
}
