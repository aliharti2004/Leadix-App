<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Mail\TeamInvitation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class InvitationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email'), // Ensure user is not already registered (optional, can invite existing users logic later)
                Rule::unique('invitations', 'email')->where(function ($query) {
                    return $query->where('organization_id', auth()->user()->organization_id);
                })
            ],
            'role' => 'required|in:admin,sales,finance,viewer',
        ]);

        $invitation = Invitation::create([
            'email' => $request->email,
            'role' => $request->role,
            'token' => Str::upper(Str::random(32)),
            'organization_id' => auth()->user()->organization_id,
        ]);

        Mail::to($request->email)->send(new TeamInvitation($invitation));

        return back()->with('success', 'Invitation sent successfully!');
    }

    public function destroy(Invitation $invitation)
    {
        // Simple authorization check
        if ($invitation->organization_id !== auth()->user()->organization_id) {
            abort(403);
        }

        $invitation->delete();

        return back()->with('success', 'Invitation cancelled.');
    }
}
