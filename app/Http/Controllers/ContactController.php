<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contacts = \App\Models\Contact::where('organization_id', auth()->user()->organization_id)
            ->latest()
            ->paginate(10);

        return view('contacts.index', compact('contacts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'job_title' => 'nullable|string|max:255',
            'linkedin_url' => 'nullable|url|max:255',
        ]);

        $contact = new \App\Models\Contact($validated);
        $contact->organization_id = auth()->user()->organization_id;
        $contact->save();

        // Notify organization
        $usersToNotify = \App\Models\User::where('organization_id', auth()->user()->organization_id)->get();
        \Illuminate\Support\Facades\Notification::send($usersToNotify, new \App\Notifications\ContactCreatedNotification($contact));

        return redirect()->route('contacts.index')->with('success', 'Contact created successfully.');
    }

    public function update(Request $request, \App\Models\Contact $contact)
    {
        if ($contact->organization_id !== auth()->user()->organization_id) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'job_title' => 'nullable|string|max:255',
            'linkedin_url' => 'nullable|url|max:255',
        ]);

        $contact->update($validated);

        // Notify organization
        $usersToNotify = \App\Models\User::where('organization_id', auth()->user()->organization_id)->get();
        \Illuminate\Support\Facades\Notification::send($usersToNotify, new \App\Notifications\ContactUpdatedNotification($contact));

        return redirect()->route('contacts.index')->with('success', 'Contact updated successfully.');
    }

    public function destroy(\App\Models\Contact $contact)
    {
        if ($contact->organization_id !== auth()->user()->organization_id) {
            abort(403);
        }

        $contact->delete();

        return redirect()->route('contacts.index')->with('success', 'Contact deleted successfully.');
    }
}
