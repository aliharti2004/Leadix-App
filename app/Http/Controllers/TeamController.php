<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\User;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
        $organization = auth()->user()->organization;

        $teamMembers = $organization->users;
        $pendingInvitations = Invitation::where('organization_id', $organization->id)->get();

        return view('settings.team', compact('teamMembers', 'pendingInvitations'));
    }

    public function destroy(User $user)
    {
        $currentUser = auth()->user();

        // Security Checks
        if (!$currentUser->hasRole('admin')) {
            abort(403, 'Only admins can remove team members.');
        }

        if ($user->id === $currentUser->id) {
            return back()->with('error', 'You cannot remove yourself.');
        }

        if ($user->organization_id != $currentUser->organization_id) {
            abort(403, 'You can only remove members from your own organization.');
        }

        // Remove from organization (effectively removing access)
        $user->update(['organization_id' => null]);

        return back()->with('success', 'Team member removed successfully.');
    }
}
