<?php

namespace App\Http\Controllers;

use App\Models\ContactSocialMedia;
use App\Models\OpeningHour;
use App\Models\ContactMessage;
use App\Mail\ContactAutoReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function index()
    {
        $socialMedias = ContactSocialMedia::where('is_active', true)->orderBy('order')->get();
        $openingHours = OpeningHour::where('is_closed', false)->orderBy('order')->get();

        return view('pages.contact', compact('socialMedias', 'openingHours'));
    }

    public function store(Request $request)
    {
        // 1. Validation stricte avec messages traduits
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                'regex:/^[a-zA-ZÀ-ÿ\s\'\-]+$/u'
            ],
            'email' => 'required|email:rfc,dns|max:255',
            'message' => [
                'required',
                'string',
                'min:10',
                'max:5000',
                'regex:/^[^<>{}]+$/u'
            ]
        ], [
            'name.required' => __('contact.name_required'),
            'name.regex' => __('contact.name_regex'),
            'name.max' => __('contact.name_max'),
            'email.required' => __('contact.email_required'),
            'email.email' => __('contact.email_email'),
            'email.max' => __('contact.email_max'),
            'message.required' => __('contact.message_required'),
            'message.min' => __('contact.message_min'),
            'message.max' => __('contact.message_max'),
            'message.regex' => __('contact.message_regex'),
        ]);

        // 2. Sauvegarde en base de données
        ContactMessage::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'message' => $validated['message'],
            'is_read' => false,
        ]);

        // 3. Envoi de l'email automatique de confirmation
        try {
            Mail::to($validated['email'])->send(new ContactAutoReply($validated['name']));
        } catch (\Exception $e) {
            Log::error('Échec envoi email auto-réponse contact : ' . $e->getMessage());
        }

        // 4. Redirection avec message de succès traduit
        return redirect()->route('contact', ['locale' => app()->getLocale()])
            ->with('success', __('contact.success_message'));
    }
}
