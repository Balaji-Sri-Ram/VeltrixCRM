<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AIController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $apiKey = config('services.gemini.key');
        if (!$apiKey) {
            return response()->json(['error' => 'API Key is missing.'], 500);
        }

        // Reverted to gemini-2.0-flash as it is fully supported by the new API key and endpoints
        $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=' . $apiKey;

        try {
            $response = Http::withoutVerifying()->post($url, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $request->message]
                        ]
                    ]
                ],
                'systemInstruction' => [
                    'parts' => [
                        ['text' => "You are Veltrix AI, the intelligent virtual assistant built into VeltrixCRM. VeltrixCRM is a premium, high-end SaaS CRM platform for orchestrating customer operations, managing lead pipelines, task flows, and operational analytics. Keep your responses highly professional, clean, helpful, concise, and focused on assisting the staff or administrator with CRM capabilities."]
                    ]
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $reply = $data['candidates'][0]['content']['parts'][0]['text'] ?? 'Sorry, I could not generate a response.';
                return response()->json(['reply' => $reply]);
            }

            // Smart Fallback for Quota / API Errors to keep Veltrix AI active and helpful
            $fallbackReply = $this->getVeltrixFallbackReply($request->message);
            return response()->json(['reply' => $fallbackReply]);

        } catch (\Exception $e) {
            $fallbackReply = $this->getVeltrixFallbackReply($request->message);
            return response()->json(['reply' => $fallbackReply]);
        }
    }

    /**
     * Get a contextual fallback response about VeltrixCRM when the Gemini API is unavailable/quota-limited.
     */
    private function getVeltrixFallbackReply(string $message): string
    {
        $msg = strtolower($message);

        if (str_contains($msg, 'lead') || str_contains($msg, 'customer') || str_contains($msg, 'pipeline')) {
            return "In VeltrixCRM, leads and customers are managed under the 'Customers' tab. You can track contact information, pipeline stages (active/lead/inactive), and quickly inspect details or start direct WhatsApp communications.";
        }

        if (str_contains($msg, 'staff') || str_contains($msg, 'member') || str_contains($msg, 'personnel') || str_contains($msg, 'team')) {
            return "VeltrixCRM allows administrators to orchestrate team permissions in the 'Staff Management' section. You can view, add, or edit team members, assign custom roles, and inspect staff profiles via the details modal.";
        }

        if (str_contains($msg, 'task') || str_contains($msg, 'todo') || str_contains($msg, 'assign')) {
            return "The 'Tasks' section is designed to manage day-to-day deliverables. You can create new tasks, prioritize them, assign them to team members, and track completion status in real-time.";
        }

        if (str_contains($msg, 'chart') || str_contains($msg, 'analytic') || str_contains($msg, 'metric') || str_contains($msg, 'stat')) {
            return "The 'Analytics' dashboard gives you visual insights into staff performance flows, lead distributions, and operational milestones, helping you make data-driven decisions.";
        }

        if (str_contains($msg, 'price') || str_contains($msg, 'plan') || str_contains($msg, 'cost') || str_contains($msg, 'upgrade')) {
            return "VeltrixCRM offers flexible plans tailored to your team size. You can upgrade your plan directly by navigating to the Pricing page or clicking the 'Upgrade Experience' box at the bottom of the sidebar.";
        }

        if (str_contains($msg, 'hello') || str_contains($msg, 'hi ') || str_contains($msg, 'hey')) {
            return "Hello! I am Veltrix AI. How can I assist you with your leads, staff management, tasks, or analytics today?";
        }

        return "VeltrixCRM is a premium SaaS customer management platform designed for operational intelligence and seamless team collaboration. You can manage customer pipelines, delegate team tasks, inspect staff performance, and utilize live analytics directly from the navigation sidebar.";
    }
}
